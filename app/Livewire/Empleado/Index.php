<?php

namespace App\Livewire\Empleado;

use App\Models\Empleado;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    
    public $search = '';

    public function datos($id_emp, $modo)
    {
        session(['modo' => $modo]);
        return redirect()->route('empleados.editar', $id_emp);
    }

    public function mostrar_toast()
    {
        if(session('mensaje_guardar'))
        {
            session('mensaje_guardar') === 'editar' ? $mensaje_toast = 'Empleado editado correctamente' : $mensaje_toast = 'Empleado creado correctamente';
            
            $this->dispatch(
                'toast-basico',
                mensaje: $mensaje_toast,
                type: 'success'
            );

            session()->forget('mensaje_guardar');
        }
    }

    // Cambiar de estado si la fecha de egreso es menor o igual a la fecha actual
    public function cambiar_estado()
    {
        $empleados = Empleado::all();
        foreach ($empleados as $empleado) {
            if ($empleado->fecha_egreso_emp <= date('Y-m-d') && $empleado->fecha_egreso_emp != null && $empleado->id_modalidad == 2) {
                $empleado->estado_emp = 0;
                $empleado->save();
            }elseif($empleado->fecha_egreso_emp > date('Y-m-d') && $empleado->fecha_egreso_emp != null && $empleado->id_modalidad == 2){
                $empleado->estado_emp = 1;
                $empleado->save();
            }
        }
    }

    public function mount()
    {
        $this->cambiar_estado();
    }

    public function render()
    {
        $empleados = Empleado::search($this->search)
            ->orderBy('id_emp', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.empleado.index', [
            'empleados' => $empleados,
        ]);
    }
}
