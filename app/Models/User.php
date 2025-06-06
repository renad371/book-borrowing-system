<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,  HasRoles, HasApiTokens ;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>

     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];
    public function ratings()
    {
        return $this->hasMany(Review::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'borrowable');
    }



    public function receivedRatings()
    {
        return $this->morphMany(Review::class, 'rateable');
    }
 
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
