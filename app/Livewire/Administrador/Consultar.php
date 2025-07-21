<?php

namespace App\Livewire\Administrador;

use Livewire\Component;

class Consultar extends Component
{
    public $funcionarioId;
    public $funcionarioData = [];
    public $modo = 'consultar';

    protected $listeners = [
        'editarFuncionario' => 'activarEdicion',
        'abrirModalconEdicion' => 'abrirModalconEdicion',
    ];
    public function mount($id = null, $modo = 'consultar')
    {
        $this->modo = $modo;
        $this->funcionarioId = $id;
        $this->loadFuncionarioData();
    }

    public function loadFuncionarioData()
    {
        if ($this->funcionarioId) {
            $funcionario = \App\Models\Funcionario::with(['persona', 'user'])->find($this->funcionarioId);
            if ($funcionario) {
                $this->funcionarioData = $funcionario->toArray();
            }
        }
    }

    public function activarEdicion($id)
    {
        $this->funcionarioId = $id;
        $this->modo = 'editar';
        $this->loadFuncionarioData();
    }

    public function abrirModalconEdicion($id)
    {
        $this->funcionarioId = $id;
        $this->modo = 'editar';
        $this->loadFuncionarioData();
    }



    public function updated($propertyName)
    {
        if ($this->modo === 'editar') {
            $this->guardarCambios();
        }
    }

public function guardarCambios()
{
    $funcionario = \App\Models\Funcionario::with('persona')->find($this->funcionarioId);
    if ($funcionario && isset($this->funcionarioData['persona'])) {
        // Actualiza los campos principales de persona
        $funcionario->persona->primer_nombre = $this->funcionarioData['persona']['primer_nombre'] ?? $funcionario->persona->primer_nombre;
        $funcionario->persona->segundo_nombre = $this->funcionarioData['persona']['segundo_nombre'] ?? $funcionario->persona->segundo_nombre;
        $funcionario->persona->primer_apellido = $this->funcionarioData['persona']['primer_apellido'] ?? $funcionario->persona->primer_apellido;
        $funcionario->persona->segundo_apellido = $this->funcionarioData['persona']['segundo_apellido'] ?? $funcionario->persona->segundo_apellido;
        $funcionario->persona->nacionalidad = $this->funcionarioData['persona']['nacionalidad'] ?? $funcionario->persona->nacionalidad;
        $funcionario->persona->cedula = $this->funcionarioData['persona']['cedula'] ?? $funcionario->persona->cedula;
        $funcionario->persona->sexo = $this->funcionarioData['persona']['sexo'] ?? $funcionario->persona->sexo;
        $funcionario->persona->correo = $this->funcionarioData['persona']['correo'] ?? $funcionario->persona->correo;
        $funcionario->persona->save();

        // Actualiza los campos propios de funcionario
        $funcionario->credencial = $this->funcionarioData['credencial'] ?? $funcionario->credencial;
        $funcionario->save();
        // Recarga los datos actualizados
        $this->loadFuncionarioData();
    }
}



    public function limpiarCampos()
    {
        $this->reset(['funcionarioData']);
        $this->modo = 'consultar';
        $this->loadFuncionarioData();
    }



    public function render()
    {
        return view('livewire.administrador.consultar', [
            'funcionario' => $this->funcionarioData,
            'modo' => $this->modo,
        ]);
    }
}
