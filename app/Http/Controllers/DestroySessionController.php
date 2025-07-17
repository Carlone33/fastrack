<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestroySessionController extends Controller
{
    public function destroy(Request $request)
    {
        // Elimina solo la variable de sesión que desees, por ejemplo 'user_id'
        $request->session()->flush();
        // Puedes olvidar más variables si lo necesitas:
        // $request->session()->forget(['user_id', 'rifa', ...]);

        return redirect('/login');
    }
}
