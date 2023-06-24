<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function Seats()
    {
        return $this->hasMany(Booking_Seat::class);
    }

    public function Show()
    {
        return $this->belongsTo(Show::class);
    }
}
