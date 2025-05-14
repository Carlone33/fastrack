<?php

namespace App\Livewire;

use App\Models\Solicitud;
use App\Models\RegistroPolicial;
use Livewire\Component;

class InterfazAbogado extends Component
{


    public $search = '';

    public $tipo_funcionario;

    public $selected_id = 0;

    public $rol_usuario = '';


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

    public function render()
    {
        // Traer registros policiales con la información relacionada
        $registrosPoliciales = RegistroPolicial::select('registro_policial.*')
            ->join('solicitud', 'registro_policial.solicitud_id', '=', 'solicitud.id')
            ->join('persona as solicitante', 'solicitud.solicitante_persona_id', '=', 'solicitante.id')
            ->leftJoin('persona as apoderado', 'solicitud.apoderado_persona_id', '=', 'apoderado.id')
            ->leftJoin('funcionario', 'solicitud.abogado_funcionario_id', '=', 'funcionario.id') // singular aquí
            ->with([
                'solicitud',
                'solicitud.solicitante',
                'solicitud.apoderado',
                'solicitud.abogado'
            ])
            ->where("solicitud.{$this->tipo_funcionario}", '=',  $this->selected_id)
            ->orderBy('registro_policial.created_at', 'desc')
            ->get();

        // Si también quieres las transcripciones, puedes agregarlas aquí
        $transcripciones = Solicitud::with(['solicitante', 'apoderado', 'abogado'])
            ->where('tipo_solicitud', 'Transcripción')
            ->orderBy('created_at', 'desc')
            ->get();

        // Unir ambos resultados si lo necesitas
        $resultados = $transcripciones->concat($registrosPoliciales);

        return view('livewire.interfaz-abogado', [
            'resultados' => $resultados,
            'registrosPoliciales' => $registrosPoliciales,
            'tipo_funcionario' => $this->tipo_funcionario,
        ]);
    }
}
