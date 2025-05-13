<?php

namespace App\Livewire\Administrador;

use Livewire\Component;

class Editar extends Component
{

    public $funcionarioId;

    protected $listeners = ['recibirFuncionarioId'];

    public function recibirFuncionarioId($id)
    {
        $this->funcionarioId = $id;
        // Aquí puedes cargar los datos del funcionario si lo necesitas
    }


    public function limpiarCampos()
    {
        $this->reset(); // Esto limpia todas las propiedades públicas
    }

    public function render()
    {
        return view('livewire.administrador.editar');
    }
}
