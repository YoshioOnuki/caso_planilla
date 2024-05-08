<?php

namespace App\Livewire\Empleado;

use App\Models\Area;
use App\Models\Beneficio;
use App\Models\Empleado;
use App\Models\HistorialSalario;
use App\Models\Modalidad;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    #[Validate('required')]
    public $nombre;
    #[Validate('required')]
    public $apellido_paterno;
    #[Validate('required')]
    public $apellido_materno;
    #[Validate('required')]
    public $documento;
    #[Validate('required')]
    public $fecha_nacimiento;
    #[Validate('required')]
    public $genero;
    #[Validate('required')]
    public $salario;
    #[Validate('required')]
    public $fecha_ingreso;
    #[Validate('required')]
    public $fecha_egreso;
    #[Validate('required')]
    public $jornada_laboral;
    #[Validate('required')]
    public $area;
    #[Validate('required')]
    public $modalidad;

    public function guardar()
    {
        $this->validate();

        try {

            DB::beginTransaction();

            $persona = new Persona();
            $persona->nombres_persona = $this->nombre;
            $persona->apellido_pat_persona = $this->apellido_paterno;
            $persona->apellido_mat_persona = $this->apellido_materno;
            $persona->documento_persona = $this->documento;
            $persona->fecha_naci_persona = $this->fecha_nacimiento;
            $persona->genero_persona = $this->genero;
            $persona->save();

            $empleado = new Empleado();
            $empleado->codigo_emp = generarCodigoEmpleado();
            $empleado->salario_emp = $this->salario;
            $empleado->fecha_ingreso_emp = $this->fecha_ingreso;
            $empleado->fecha_egreso_emp = $this->fecha_egreso;
            $empleado->estado_emp = 1;
            $empleado->id_area = $this->area;
            $empleado->id_modalidad = $this->modalidad;
            $empleado->id_jornada_lab = $this->jornada_laboral;
            $empleado->id_persona = $persona->id_persona;
            $empleado->save();

            $historial = new HistorialSalario();
            $historial->id_emp = $empleado->id_emp;
            $historial->salario_act_historial = $this->salario;
            $historial->fecha_cambio_historial = date('Y-m-d');
            $historial->save();

            $beneficios = Beneficio::all();
            foreach ($beneficios as $beneficio) {
                $empleado->beneficio()->attach($beneficio->id_bene);
            }

            DB::commit();

            session(['mensaje_guardar' => 'crear']);
            return redirect()->route('empleados');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al guardar el empleado'. $e->getMessage(),
                type: 'error'
            );
        }

    }

    public function render()
    {
        $area_model = Area::where('estado_area', 1)->get();
        $modalidad_model = Modalidad::where('estado_modalidad', 1)->get();

        return view('livewire.empleado.create', [
            'area_model' => $area_model,
            'modalidad_model' => $modalidad_model,
        ]);
    }
}
