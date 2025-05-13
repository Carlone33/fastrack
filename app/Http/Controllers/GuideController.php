<?php

namespace App\Http\Controllers;

use App\Services\GuideNumberService;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    protected $guideNumberService;

    public function __construct(GuideNumberService $guideNumberService)
    {
        $this->guideNumberService = $guideNumberService;
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'sometimes|string|max:20',
            'prefix' => 'sometimes|string|max:5',
            'digits' => 'sometimes|integer|min:3|max:8',
            'year' => 'sometimes|integer|digits:4'
        ]);

        $guideNumber = $this->guideNumberService->generate(
            $validated['type'] ?? 'default',
            $validated['prefix'] ?? 'G',
            $validated['digits'] ?? 4,
            $validated['year'] ?? null,
            false // Generación real
        );

        return response()->json([
            'guide_number' => $guideNumber,
            'message' => 'Número de guía generado con éxito'
        ]);
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'type' => 'sometimes|string|max:20',
            'prefix' => 'sometimes|string|max:5',
            'digits' => 'sometimes|integer|min:3|max:8',
            'year' => 'sometimes|integer|digits:4'
        ]);

        $preview = $this->guideNumberService->generate(
            $validated['type'] ?? 'default',
            $validated['prefix'] ?? 'G',
            $validated['digits'] ?? 4,
            $validated['year'] ?? null,
            true // Modo previsualización
        );

        return response()->json([
            'preview' => $preview,
            'message' => 'Previsualización generada y guardada'
        ]);
    }

    public function getPreview(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:20',
            'year' => 'sometimes|integer|digits:4'
        ]);

        $preview = $this->guideNumberService->getCurrentPreview(
            $validated['type'],
            $validated['year'] ?? null
        );

        return response()->json([
            'preview' => $preview,
            'message' => $preview ? 'Previsualización obtenida' : 'No hay previsualización disponible'
        ]);
    }
}
