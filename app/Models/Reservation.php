<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'plant_id',
        'done',
    ];

    public function Plant(){
        return $this->belongsToOne(Plant::class);   
    }
}
