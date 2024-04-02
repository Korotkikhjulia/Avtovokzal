<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\buse;
use App\Models\route;

class trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_trip',
        'bus_id',
        'route_id',
        'departure_date',
        'arrive_date',
    ];

}
