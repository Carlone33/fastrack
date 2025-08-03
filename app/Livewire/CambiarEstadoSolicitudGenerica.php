<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\MovimientosSolicitud;
use Illuminate\Support\Facades\Auth;

class CambiarEstadoSolicitudGenerica extends Component
{
    public $solicitudId;
    public $solicitud;
    public $nuevo_estado;
    public $comentario = '';

    public $estados = [
        'Recibida',
        'En revisión',
        'Culminada',
    ];

    public function mount($solicitud)
    {
        $this->solicitudId = $solicitud;
        $this->solicitud = Solicitud::find($solicitud);
        $this->nuevo_estado = $this->solicitud->estado_solicitud ?? '';
    }

    public function actualizarEstado()
    {
        if (!$this->solicitud) {
            session()->flash('error', 'Solicitud no encontrada.');
            return redirect()->route('menu');
        }
        if (empty(trim($this->comentario))) {
            session()->flash('error', 'Debes ingresar un comentario para cambiar el estado.');
            return;
        }
        $estadoAnterior = $this->solicitud->estado_solicitud ?? 'Desconocido';
        $estadoNuevo = $this->nuevo_estado;
        $this->solicitud->estado_solicitud = $estadoNuevo;
        $this->solicitud->save();
        MovimientosSolicitud::create([
            'solicitud_id' => $this->solicitud->id,
            'usuario_id' => Auth::id(),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'descripcion' => $this->comentario,
        ]);
        session()->flash('success', 'Estado actualizado correctamente a: ' . $estadoNuevo);
        return redirect()->route('menu');
    }

    public function render()
    {
        return view('livewire.cambiar-estado-solicitud-generica');
    }
}
