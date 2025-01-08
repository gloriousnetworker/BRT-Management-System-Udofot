<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject; // Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject // Implement the JWTSubject interface
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * The attributes that should be cast.
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

    // Implement the methods required by JWTSubject interface:

    public function getJWTIdentifier()
    {
        return $this->getKey(); // The unique identifier of the user (typically the ID)
    }

    public function getJWTCustomClaims()
    {
        return []; // Custom claims (empty array if you don't need any)
    }
}
