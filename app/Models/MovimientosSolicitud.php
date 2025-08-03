<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosSolicitud extends Model
{
    use HasFactory;

    protected $table = 'movimientos_solicitud';

    protected $fillable = [
        'solicitud_id',
        'usuario_id',
        'estado_anterior',
        'estado_nuevo',
        'descripcion',
    ];

    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
