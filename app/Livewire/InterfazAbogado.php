<?php

namespace App\Livewire;

use App\Models\Solicitud;
use App\Models\RegistroPolicial;
use App\Models\RegistroUnico;
use App\Models\SolicitudAdministrativa;
use Livewire\Attributes\Computed;
use Livewire\Component;

class InterfazAbogado extends Component
{


    public $search = '';

    public $tipo_funcionario;

    public $selected_id = 0;

    public $rol_usuario = '';


    public $modalOpen = false;
    public $editando = false;
    public $registroSeleccionado = null;
    public $modalTitle = 'Exclusión Registro Policial';

    public $tipoSolicitud = '';

    public function abrirModal($id)
    {
        $this->selected_id = $id;
        $this->modalOpen = true;

        $this->registroSeleccionado = RegistroPolicial::with([
            'solicitud',
            'solicitud.solicitante',
            'solicitud.apoderado',
            'solicitud.abogado'
        ])->find($id);
    }

    public function mount()
    {
        $this->rol_usuario = auth()->user()->roles->pluck('name')->first() ?? '';

        $this->selected_id = auth()->user()->funcionario->id;

        if ($this->rol_usuario == 'Transcriptor') {

            $this->tipo_funcionario = 'registrador_funcionario_id';
        } else {

            $this->tipo_funcionario = 'abogado_funcionario_id';
        }
    }

    #[Computed()]
    public function resultados()
    {
        // Filtra según el tipo seleccionado
            if ($this->tipoSolicitud === 'RegistroPolicial') {
            return RegistroPolicial::with([
                'solicitud',
                'solicitud.solicitante',
                'solicitud.apoderado',
                'solicitud.abogado',
                'solicitud.registroSolicitud',
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        if ($this->tipoSolicitud === 'Transcripción') {
            return Solicitud::with([
                'solicitante',
                'apoderado',
                'abogado',
                'registroSolicitud',
            ])
                ->where('tipo_solicitud', 'Transcripción')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        if ($this->tipoSolicitud === 'Administrativa') {
            return SolicitudAdministrativa::with([
                'solicitante',
                'apoderado',
                'abogado',
                'registroSolicitud',
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        if ($this->tipoSolicitud === 'RegistroUnico') {
            return RegistroUnico::with([
                // relaciones necesarias
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        // Si no hay filtro, muestra todos juntos (puedes dejar solo uno si prefieres)
        // Aquí puedes concatenar y paginar manualmente si lo necesitas
        return RegistroPolicial::with([
            'solicitud',
            'solicitud.solicitante',
            'solicitud.apoderado',
            'solicitud.abogado',
            'solicitud.registroSolicitud',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(8);
    }

    public function render()
    {
        return view('livewire.interfaz-abogado', [
            'tipo_funcionario' => $this->tipo_funcionario,
            'resultados' => $this->resultados, // <-- agrega esto
        ]);
    }
}
