<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SolicitudAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'solicitud_administrativa';

    protected $fillable = [
        'solicitud_id',
        'guia'
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function dictamen(): HasOne
    {
        return $this->hasOne(Dictamen::class);
    }

    // Acceso directo al solicitante a través de la solicitud
    public function solicitante()
    {
        return $this->solicitud ? $this->solicitud->solicitante() : null;
    }
}
