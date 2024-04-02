<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\trip;
class route extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'number_route',
        'start_stop',
        'end_stop',
        'price',
    ];
    public $timestamps = false;
    public function lists(){
        return $this->hasMany(trip::class);
    }
}
