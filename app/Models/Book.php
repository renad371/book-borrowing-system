<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable =
    [
        'title',
        'published_at',
        'category',
        'cover_image',
        'language',
        'copies_available',
        'author_id',
        'status'
        

    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function ratings()
    {
        return $this->morphMany(Review::class, 'rateable');
    }
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
