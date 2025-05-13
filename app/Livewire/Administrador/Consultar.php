<?php

namespace App\Livewire\Administrador;

use Livewire\Component;

class Consultar extends Component
{
    public $funcionario;
    public $modoEdicion = false;
    public $abrirEnModoEdicion = false;

    protected $listeners = [
        'editarFuncionario' => 'activarEdicion',
        'abrirModalconEdicion' => 'abrirModalconEdicion',
    ];
    public function mount($funcionario = null, $abrirEnModoEdicion = false)
    {
        $this->funcionario = $funcionario;
        $this->abrirEnModoEdicion = $abrirEnModoEdicion;
        $this->modoEdicion = $abrirEnModoEdicion;
    }

    public function activarEdicion($funcionario)
    {
        $this->funcionario = $funcionario;
        $this->modoEdicion = true;
    }

    public function abrirModalconEdicion($id)
    {
        $this->modoEdicion = true;
        // Si tienes una variable para abrir el modal (ejemplo $modalAbierto), actívala aquí:
        // $this->modalAbierto = true;
    }
    
    
    
    public function updated($propertyName)
    {
        if ($this->modoEdicion) {
            $this->guardarCambios();
        }
    }

public function guardarCambios()
{
    // Busca el funcionario en la base de datos
    $funcionario = \App\Models\Funcionario::find($this->funcionario['id']);
    if ($funcionario) {
        // Actualiza los campos principales
        $funcionario->primer_nombre = $this->funcionario['primer_nombre'];
        $funcionario->segundo_nombre = $this->funcionario['segundo_nombre'];
        $funcionario->primer_apellido = $this->funcionario['primer_apellido'];
        $funcionario->segundo_apellido = $this->funcionario['segundo_apellido'];
        $funcionario->nacionalidad = $this->funcionario['nacionalidad'];
        $funcionario->cedula = $this->funcionario['cedula'];
        $funcionario->credencial = $this->funcionario['credencial'];

        $funcionario->save();

        // Si tienes relaciones (ej: persona, users), actualízalas aquí también
        // Ejemplo:
        // $funcionario->persona->correo = $this->funcionario['correo'];
        // $funcionario->persona->save();
    }
}



    public function limpiarCampos()
    {
        $this->reset();
    }



    public function render()
    {


        return view('livewire.administrador.consultar');
    }
}
