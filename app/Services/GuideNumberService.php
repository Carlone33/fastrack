<?php

namespace App\Services;

use App\Models\GuideSequence;
use Illuminate\Support\Str;

class GuideNumberService
{
    public function generate(
        string $type = 'default',
        string $prefix = 'G',
        int $digits = 4,
        ?int $year = null,
        bool $preview = false
    ): string {
        $year = $year ?? now()->year;

        $sequence = GuideSequence::firstOrCreate(
            ['type' => $type, 'year' => $year],
            ['last_number' => 0, 'preview' => '']
        );

        if ($preview) {
            // Generamos la previsualización (last_number + 1) pero no incrementamos
            $nextNumber = $sequence->last_number + 1;
            $previewNumber = $this->formatNumber($prefix, $year, $nextNumber, $digits);

            // Guardamos la previsualización en la base de datos
            $sequence->update(['preview' => $previewNumber]);

            return $previewNumber;
        }

        // Generación real - incrementamos el contador
        $sequence->increment('last_number');

        // Limpiamos la previsualización después de generar el número real
        $sequence->update(['preview' => null]);

        return $this->formatNumber($prefix, $year, $sequence->last_number, $digits);
    }

    protected function formatNumber(string $prefix, int $year, int $number, int $digits): string
    {
        return Str::upper($prefix) . '-' .
                $year . '-' .
                str_pad($number, $digits, '0', STR_PAD_LEFT);
    }

    public function getCurrentPreview(string $type, ?int $year = null): ?string
    {
        $year = $year ?? now()->year;

        return GuideSequence::where('type', $type)
                    ->where('year', $year)
                    ->value('preview');
    }
}
