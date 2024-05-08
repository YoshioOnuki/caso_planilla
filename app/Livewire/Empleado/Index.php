<?php

namespace App\Livewire\Empleado;

use App\Models\Empleado;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

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

    public function render()
    {
        $empleados = Empleado::search($this->search)
            ->where('estado_emp', 1)
            ->paginate(10);

        return view('livewire.empleado.index', [
            'empleados' => $empleados,
        ]);
    }
}
