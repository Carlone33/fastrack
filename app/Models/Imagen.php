<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagen';

    protected $fillable = [
        'url',
        'tipo',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    public function solicitudes(): BelongsToMany
    {
        return $this->belongsToMany(Solicitud::class, 'imagen_solicitud');
    }
}
