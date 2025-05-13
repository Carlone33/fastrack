<?php

namespace App\Livewire\Administrador;

use Livewire\Component;

class Crear extends Component
{
    public $funcionarioId;
    protected $listeners = ['recibirFuncionarioId'];

    public function recibirFuncionarioId($id)
    {
        $this->funcionarioId = $id;
        // Lógica adicional...
    }



    public function limpiarCampos()
    {
        $this->reset(); // Esto limpia todas las propiedades públicas
    }



    public function render()
    {
        return view('livewire.administrador.crear');
    }
}
