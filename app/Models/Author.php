<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
   

    protected $fillable = ['name', 'bio'];

    public function ratings()
    {
        return $this->morphMany(Review::class, 'rateable');
    }
     public function books()
    {
        return $this->hasMany(Book::class);
    }
}

