<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrazaAcceso extends Model
{
    use HasFactory;

    protected $table = 'traza_acceso';

    protected $fillable = [
        'user_id',
        'ip',
        'login',
        'logout',
        'fallido'
    ];

    protected $casts = [
        'login' => 'datetime',
        'logout' => 'datetime',
    ];  

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
