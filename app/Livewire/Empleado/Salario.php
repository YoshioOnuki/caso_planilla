<?php

namespace App\Livewire\Empleado;

use App\Models\Empleado;
use App\Models\HistorialSalario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Salario extends Component
{

    public $id_empleado;
    public $empleado;
    #[Validate('required')]
    public $salario_nuevo;
    public $salario_act;
    public $salario_ant;
    public $fecha;

    public function mount($id_emp)
    {
        $this->id_empleado = $id_emp;
        $this->empleado = Empleado::find($id_emp);
        $this->salario_act = $this->empleado->salario_emp;

        $ant = HistorialSalario::where('id_emp', $this->id_empleado)
            ->where('salario_act_historial', '=', $this->salario_act)->first();
        if ($ant) {
            $this->salario_ant = $ant->salario_ant_historial ?? 'N/A';
        }
        
    }

    public function actualizar_salario()
    {
        $this->validate();

        $salario = new HistorialSalario();
        $salario->id_emp = $this->id_empleado;
        $salario->salario_ant_historial = $this->empleado->salario_emp;
        $salario->salario_act_historial = $this->salario_nuevo;
        $salario->fecha_cambio_historial = date('Y-m-d');
        $salario->save();

        $emple = Empleado::find($this->id_empleado);
        $emple->salario_emp = $salario->salario_act_historial;
        $emple->save();

        $this->mount($this->id_empleado);
        $this->reset('salario_nuevo');

        $this->dispatch(
            'toast-basico',
            mensaje: 'Salario actualizado correctamente',
            type: 'success'
        );
    }

    public function render()
    {
        $salarios = HistorialSalario::where('id_emp', $this->id_empleado)
            ->orderBy('id_emp', 'desc')->get();

        return view('livewire.empleado.salario', [
            'salarios' => $salarios,
        ]);
    }
}
