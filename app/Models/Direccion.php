<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direccion';

    protected $fillable = [
        'estado',
        'municipio',
        'parroquia',
        'calle',
        'casa-edificio',
        'piso',
        'apartamento'
    ];

    public function unidadAdministrativa(): HasOne
    {
        return $this->hasOne(UnidadAdministrativa::class);
    }

    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class, 'persona_direccion');
    }
}
