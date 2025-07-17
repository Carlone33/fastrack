<?php

namespace App\Livewire;

use Livewire\Component;

class Inicio extends Component
{
    public function mount()
    {
        $usuario = auth()->user();

        if (
            is_null($usuario->pregunta_1) ||
            is_null($usuario->pregunta_2) ||
            is_null($usuario->respuesta_1) ||
            is_null($usuario->respuesta_2)
        ) {
            return redirect()->route('establecer.preguntas');
        }
    }

    public function render()
    {
        return view('livewire.inicio');
    }
}

