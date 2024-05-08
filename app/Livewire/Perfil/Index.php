<?php

namespace App\Livewire\Perfil;

use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    public $usuario;

    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $documento;
    public $fecha_nacimiento;
    public $genero;

    public $contraseña;
    public $confirmar_contraseña;


    public function eliminar_avatar()
    {
        dd('eliminar avatar');
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'documento' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
        ]);

        if($this->contraseña)
        {
            $this->validate([
                'contraseña' => 'required',
                'confirmar_contraseña' => 'required|same:contraseña',
            ]);

            $this->usuario->update([
                'contrasenia_usuario' => bcrypt($this->contraseña),
            ]);

            $this->contraseña = '';
            $this->confirmar_contraseña = '';
        }

        $this->usuario->persona->update([
            'nombres_persona' => $this->nombre,
            'apellido_pat_persona' => $this->apellido_paterno,
            'apellido_mat_persona' => $this->apellido_materno,
            'documento_persona' => $this->documento,
            'fecha_naci_persona' => $this->fecha_nacimiento,
            'genero_persona' => $this->genero,
        ]);

        $this->dispatch(
            'toast-basico',
            mensaje: 'Datos actualizados correctamente',
            type: 'success'
        );
    }

    public function mount()
    {
        $this->usuario = Usuario::find(auth()->user()->id_usuario);

        $this->nombre = $this->usuario->persona->nombres_persona;
        $this->apellido_paterno = $this->usuario->persona->apellido_pat_persona;
        $this->apellido_materno = $this->usuario->persona->apellido_mat_persona;
        $this->documento = $this->usuario->persona->documento_persona;
        $this->fecha_nacimiento = $this->usuario->persona->fecha_naci_persona;
        $this->genero = $this->usuario->persona->genero_persona;

    }

    public function render()
    {
        return view('livewire.perfil.index');
    }
}
