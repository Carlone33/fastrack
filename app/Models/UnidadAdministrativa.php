<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'unidad_administrativa';

    protected $fillable = [
        'nombre',
        'codigo',
    ];

    // public function jefe(): BelongsTo
    // {
    //     return $this->belongsTo(Funcionario::class, 'jefe_id');
    // }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }
}
