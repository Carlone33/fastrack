<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\RegistroPolicial;
use App\Models\MovimientosSolicitud;
use Illuminate\Support\Facades\Auth;

class CambiarEstadoSolicitud extends Component
{
    public $registroId;
    public $registro;
    public $nuevo_estado;

    public $estados = [
        'Pendiente',
        'En proceso',
        'Revisado por abogado',
        'Finalizado',
        'Archivado',
    ];

    public $comentario = '';

    public function mount($registroId)
    {
        $this->registroId = $registroId;
        $this->registro = RegistroPolicial::with('solicitud')->find($registroId);
        $this->nuevo_estado = $this->registro->solicitud->estado_solicitud ?? '';
    }

    public function actualizarEstado()
    {
        if (!$this->registro || !$this->registro->solicitud) {
            session()->flash('error', 'Registro no encontrado.');
            return redirect()->route('menu');
        }
        if (empty(trim($this->comentario))) {
            session()->flash('error', 'Debes ingresar un comentario para cambiar el estado.');
            return;
        }
        $estadoAnterior = $this->registro->solicitud->estado_solicitud ?? 'Desconocido';
        $estadoNuevo = $this->nuevo_estado;
        $this->registro->solicitud->estado_solicitud = $estadoNuevo;
        $this->registro->solicitud->save();
        MovimientosSolicitud::create([
            'solicitud_id' => $this->registro->solicitud->id,
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
        return view('livewire.cambiar-estado-solicitud');
    }
}
