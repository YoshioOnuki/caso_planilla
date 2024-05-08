<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Sidebar extends Component
{
    public $usuario;
    public $persona;

    public function logout() {
        auth()->logout();
        return redirect()->route('login');
    }

    public function render() {
        $this->usuario = auth()->user();
        $this->persona = $this->usuario->persona;
        $nombre = $this->persona->soloPrimerosNombres;

        return view('livewire.components.sidebar', [
            'nombre' => $nombre
        ]);
    }
}
