<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroPolicial extends Model
{
    use HasFactory;

    protected $table = 'registro_policial';

    protected $fillable = [
        'solicitud_id',
        'guia',
        'numero_oficio',
        'fecha_oficio',
        'nombre_tribunal',
        'numero_expediente_tribunal',
        'motivo',
        'verificado',
        'verificadopor_persona_id',
        'fecha_verificacion'
    ];

    /**
     * Relación: Un registro policial pertenece a una solicitud.
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    /**
     * Relación: Persona que verificó el registro policial.
     */
    public function verificadoPor(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'verificadopor_persona_id');
    }
}
