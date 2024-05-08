<?php

namespace App\Livewire\Auth;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Login - Sistema de Planilla')]
class Login extends Component
{
    #[Validate('required')]
    public $usuario;
    #[Validate('required')]
    public $contraseña;

    public function iniciar_sesion()
    {
        $this->validate();

        $usuario = Usuario::where('nombre_usuario', $this->usuario)->first();
        if ($usuario) {
            if (Hash::check($this->contraseña, $usuario->contrasenia_usuario)) {
                auth()->login($usuario, false);
                redirect()->route('home');
            } else {
                $this->addError('usuario', 'Las credenciales son incorrectas');
                $this->addError('contraseña', 'Las credenciales son incorrectas');
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Las credenciales son incorrectas',
                    type: 'error'
                );
            }
        } else {
            $this->addError('usuario', 'Las credenciales son incorrectas');
            $this->addError('contraseña', 'Las credenciales son incorrectas');
            $this->dispatch(
                'toast-basico',
                mensaje: 'Las credenciales son incorrectas',
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
