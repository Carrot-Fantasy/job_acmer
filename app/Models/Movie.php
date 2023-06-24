<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function Genres() {
        return $this->belongsToMany(Genre::class, "movie_genre");
    }

    public function Directors() {
        return $this->belongsToMany(Director::class, "movie_director");
    }

    public function Performers() {
        return $this->belongsToMany(Performer::class, "movie_performer");
    }

    public function Shows() {
        return $this->hasMany(Show::class);
    }
}
