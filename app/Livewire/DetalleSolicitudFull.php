<?php

namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class DetalleSolicitudFull extends Component
{
    public $registro;
    public $tipoSolicitud;
    public $tipoFuncionario;

    public function mount($id, $tipo, $funcionario)
    {
        $this->tipoSolicitud = $tipo;
        $this->tipoFuncionario = $funcionario;

        // Buscar el registro según el tipo
        if ($tipo === 'RegistroPolicial') {
            $this->registro = \App\Models\RegistroPolicial::with(['solicitud.solicitante', 'solicitud.imagenes'])->findOrFail($id);
        } elseif ($tipo === 'Administrativa') {
            $this->registro = \App\Models\SolicitudAdministrativa::with(['solicitud.solicitante', 'solicitud.imagenes'])->findOrFail($id);
        } elseif ($tipo === 'RegistroUnico') {
            $this->registro = \App\Models\RegistroUnico::with(['solicitud.solicitante', 'solicitud.imagenes'])->findOrFail($id);
        } else {
            // Fallback: buscar en Solicitud
            $this->registro = \App\Models\Solicitud::with(['solicitante', 'imagenes'])->findOrFail($id);
        }
    }


    public function generarPDFPolicial()
    {
        $pdf = Pdf::loadView('pdf.registro-policial', ['registro' => $this->registro]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'registro_policial.pdf');
    }

    public function generarPDFAdministrativa()
    {
        $pdf = Pdf::loadView('pdf.solicitud-administrativa', ['registro' => $this->registro]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'solicitud_administrativa.pdf');
    }

    public function render()
    {
        return view('livewire.detalle-solicitud-full');
    }
}
