<?php

namespace App\Livewire;

use Livewire\Component;

class Dictamen extends Component
{
    public $foto;
    protected $guia;
    protected $cedula;
    protected $nombre;
    protected $apellido;
    protected $direccion;
    protected $telefono;
    protected $telefonolocal;
    protected $estado_ciudadano;
    protected $direccion_dependencia;
    protected $delito;
    protected $fecha_inicio;
    protected $fecha_final;
    protected $nombre_abogado;
    protected $apellido_abogado;
    protected $cedula_abogado;
    protected $telefono_abogado;

    public function submit()
    {
        
    }
    public function render()
    {
        return view('livewire.dictamen');
    }
}
