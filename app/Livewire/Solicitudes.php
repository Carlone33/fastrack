<?php

namespace App\Livewire;

use Livewire\Component;

class Solicitudes extends Component
{
    public $showAssigned = ''; // Inicializa la propiedad como una cadena vacía

    public function render()
    {
        return view('livewire.solicitudes');
    }
}
