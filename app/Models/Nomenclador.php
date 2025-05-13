<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenclador extends Model
{
    use HasFactory;


    protected $table = 'nomenclador_geografico';
    protected $fillable = [
        'nombre',
        'codigo',
        'tipo',
        'padre',
    ];
}
