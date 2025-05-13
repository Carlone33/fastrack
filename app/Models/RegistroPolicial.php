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
        'numero_causa_tribunal',
        'numero_expediente_tribunal',
        'tipo_verificacion',
        'verificado',
        'verificadopor_persona_id',
        'fecha_verificacion'
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function verificadoPor(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'verificadopor_persona_id');
    }
}
