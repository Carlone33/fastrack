<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PreguntaSeguridadController extends Controller
{
    public function verificar(Request $request)
    {
        $userId = session('user_id');
        $rifa = session('orden');
        $user = User::find($userId);

        // Asumiendo que las preguntas están en el mismo orden que en la sesión
        $pregunta1 = $rifa['pregunta1'];

        // Busca las respuestas correctas según la pregunta
        $respuestas = [
            $user->pregunta_1 => $user->respuesta_1,
            $user->pregunta_2 => $user->respuesta_2,
            $user->pregunta_3 => $user->respuesta_3,
        ];

        $valida1 = isset($respuestas[$pregunta1]) && $request->respuesta1 === $respuestas[$pregunta1];

        if ($valida1) {
            // Aquí puedes autenticar al usuario manualmente
            auth()->login($user);
            // Limpia la sesión de preguntas
            session()->forget(['user_id', 'rifa']);
            return redirect()->route('inicio');
        } else {
            return back()->withErrors(['Las respuestas no son correctas.']);
        }
    }
}
