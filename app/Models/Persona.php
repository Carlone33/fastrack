<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'nacionalidad',
        'cedula',
        'sexo',
        'correo',
        'imagen_id'
    ];

    public function imagen(): HasOne
    {
        return $this->hasOne(Imagen::class);
    }

    public function funcionario(): HasOne
    {
        return $this->hasOne(Funcionario::class);
    }

    public function direcciones(): BelongsToMany
    {
        return $this->belongsToMany(Direccion::class, 'persona_direccion');
    }

    public function telefonos(): BelongsToMany
    {
        return $this->belongsToMany(Telefono::class, 'persona_telefono');
    }

    public function solicitudesComoSolicitante(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'solicitante_persona_id');
    }

    public function solicitudesComoAbogado(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'abogado_funcionario_id');
    }

    public function solicitudesComoApoderado(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'apoderado_persona_id');
    }

    public function registrosPoliciales(): HasMany
    {
        return $this->hasMany(RegistroPolicial::class, 'verificadopor_persona_id');
    }


}

