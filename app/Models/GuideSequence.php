<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideSequence extends Model
{
    use HasFactory;

    protected $table = 'guide_sequences';

    protected $fillable = [
        'type',
        'year',
        'last_number',
        'preview'
        ];
}
