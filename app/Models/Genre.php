<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genres');
    }
}
