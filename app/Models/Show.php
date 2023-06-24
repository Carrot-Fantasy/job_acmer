<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function Cinemas() {
        return $this->belongsTo(Cinema::class, "cinema_id");
    }

    public function Booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function Movie() {
        return $this->belongsTo(Movie::class);
    }
}
