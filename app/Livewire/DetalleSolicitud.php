<?php

namespace App\Livewire;

use Livewire\Component;

class DetalleSolicitud extends Component
{
    public $registro;
    public $tipoSolicitud;
    public $tipoFuncionario;

    public function mount($registro, $tipoSolicitud, $tipoFuncionario)
    {
        $this->registro = $registro;
        $this->tipoSolicitud = $tipoSolicitud;
        $this->tipoFuncionario = $tipoFuncionario;
    }

    public function render()
    {
        return view('livewire.detalle-solicitud');
    }
}
