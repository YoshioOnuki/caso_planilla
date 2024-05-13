<?php

namespace App\Livewire\Beneficio;

use App\Models\Beneficio;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $beneficio = Beneficio::all();

        
        return view('livewire.beneficio.index', [
            'beneficio' => $beneficio,
        ]);
    }
}
