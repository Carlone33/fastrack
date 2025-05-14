<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroSolicitud extends Model
{
    use HasFactory;

    protected $table = 'registro_solicitud';

    protected $fillable = [
        'solicitud_id',
        'dependencia_id',
        'delito',
        'estado_persona',
        'fecha_apertura_siipol',
    ];

    public function unidad_administrativa(): BelongsTo
    {
        return $this->belongsTo(UnidadAdministrativa::class);
    }
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }
}

