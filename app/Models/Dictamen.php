<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dictamen extends Model
{
    use HasFactory;

    protected $table = 'dictamen';

    protected $fillable = [
        'solicitud_id',
        'guia',
        'numero_carpeta',
        'observaciones'
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }
}
