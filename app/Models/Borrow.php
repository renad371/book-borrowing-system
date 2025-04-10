<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = ['book_id', 'borrowable', 'borrowed_at', 'returned_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
