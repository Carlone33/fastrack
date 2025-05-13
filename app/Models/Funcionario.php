<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionario';

    protected $fillable = [
        'persona_id',
        'unidad_administrativa_id',
        'credencial',
        'rango',
        'cargo'
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    public function unidadAdministrativa(): BelongsTo
    {
        return $this->belongsTo(UnidadAdministrativa::class);
    }

    public function unidadACargo(): HasOne
    {
        return $this->hasOne(UnidadAdministrativa::class, 'jefe_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function solicitudesRegistradas(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'registrador_funcionario_id');
    }

    public function solicitudesAsignadas(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'abogado_funcionario_id');
    }
}
