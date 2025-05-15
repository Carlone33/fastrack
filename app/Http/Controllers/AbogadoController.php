<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbogadoController extends Controller
{
    public function buscar(Request $request)
    {
        $search = mb_strtolower($request->input('search', ''));

        $abogados = \App\Models\Funcionario::with('persona')
            ->whereHas('user.roles', function($q) {
                $q->where('name', 'Abogado');
            })
            ->whereHas('persona', function($q) use ($search) {
                $q->whereRaw('LOWER(primer_nombre) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(primer_apellido) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(cedula) LIKE ?', ["%{$search}%"]);
            })
            ->get()
            ->map(function($abogado) {
                return [
                    'id' => $abogado->id,
                    'nombre_completo' => trim(($abogado->persona->primer_nombre ?? '') . ' ' . ($abogado->persona->primer_apellido ?? '') . ' (' . ($abogado->credencial ?? '') . ')'),
                ];
            });

        return response()->json($abogados);
    }
}
