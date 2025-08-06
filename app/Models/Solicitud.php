<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';

    protected $fillable = [
        'tipo_solicitud',
        'fecha_registro',
        'registrador_funcionario_id',
        'solicitante_persona_id',
        'fecha_solicitud',
        'hora_solicitud',
        'estado_solicitud',
        'apoderado_persona_id',
        'abogado_funcionario_id'
    ];

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'registrador_funcionario_id');
    }

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'solicitante_persona_id');
    }

    public function apoderado(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'apoderado_persona_id');
    }

    public function abogado(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'abogado_funcionario_id');
    }

    public function registroUnico(): HasOne
    {
        return $this->hasOne(RegistroUnico::class);
    }

    public function solicitudAdministrativa(): HasOne
    {
        return $this->hasOne(SolicitudAdministrativa::class);
    }

    public function registroPolicial(): HasOne
    {
        return $this->hasOne(RegistroPolicial::class);
    }

    public function dictamen(): HasOne
    {
        return $this->hasOne(Dictamen::class);
    }

    public function imagenes(): BelongsToMany
    {
        return $this->belongsToMany(Imagen::class, 'imagen_solicitud');
    }
    public function registrosolicitud(): HasOne
    {
        return $this->hasOne(RegistroSolicitud::class);
    }

}
