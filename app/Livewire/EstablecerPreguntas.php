<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EstablecerPreguntas extends Component
{

    public $pregunta_0, $pregunta_1, $pregunta_2, $pregunta_3;

    public $respuesta_1, $respuesta_2, $respuesta_3, $respuesta_0;


    public function GuardarPreguntas()
    {


        $user = User::find(session('question1'));
        $user->pregunta_1 = $this->pregunta_1;
        $user->pregunta_2 = $this->pregunta_2;
        $user->pregunta_3 = $this->pregunta_3;
        $user->respuesta_1 = $this->respuesta_1;
        $user->respuesta_2 = $this->respuesta_2;
        $user->respuesta_3 = $this->respuesta_3;
        $user->save();
        session()->forget('question1');
        return redirect()->route('inicio');



    }

    public function salir()
    {
        session()->flush();
        return redirect('/login');
    }





    public function render()
    {
        return view('livewire.establecer-preguntas')
                ->layout('layouts.blank');
    }
}
