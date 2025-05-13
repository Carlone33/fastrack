<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Persona;

class Telefono extends Model
{
    use HasFactory;

    protected $table = 'telefono';

    protected $fillable = [
        'numero',
        'tipo'
    ];

    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class, 'persona_telefono');
    }

}
