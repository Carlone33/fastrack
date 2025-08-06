<?php

namespace App\Livewire;

use Livewire\Component;

class MovimientosSolicitud extends Component
{
    public $solicitud;
    public $movimientos = [];

    public function mount($solicitud)
    {
        $this->solicitud = $solicitud;
        $this->cargarMovimientos();
    }

    public function cargarMovimientos()
    {
        $this->movimientos = \App\Models\MovimientosSolicitud::where('solicitud_id', $this->solicitud)
            ->with(['usuario.funcionario.persona'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        // Siempre recarga los movimientos antes de renderizar
        $this->cargarMovimientos();
        return view('livewire.movimientos-solicitud', [
            'movimientos' => $this->movimientos
        ]);
    }
}
