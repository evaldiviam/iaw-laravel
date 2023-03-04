<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Videogame;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function videogames()
    {
	    return $this->hasMany(Videogame::class);
    }
}
