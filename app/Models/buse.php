<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buse extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'registration_number',
        'model',
        'seats',
    ];
}
