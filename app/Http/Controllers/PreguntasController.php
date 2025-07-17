<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public function json()
    {
        return response()->json([
            'pregunta_1' => [
                '¿Cuál es tu color favorito?',
                '¿Cómo se llama tu primera mascota?',
                '¿En qué ciudad naciste?',
            ],
            'pregunta_2' => [
                '¿Cuál es tu comida favorita?',
                '¿Cómo se llama tu abuelo materno?',
                '¿Cómo se llamaba tu primer colegio?',
            ],
            'pregunta_3' => [
                '¿Cuál es el nombre de tu mejor amigo de la infancia?',
                '¿Cuál es tu película favorita?',
                '¿Cuál fue tu primer trabajo?',
            ],
        ]);
    }
}
