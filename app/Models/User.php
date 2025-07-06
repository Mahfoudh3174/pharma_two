<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [
'id','status'
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
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function fcm()
    {
        return $this->hasOne(Fcm::class);
    }


    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class);
    }


    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    // Add role helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPharmacy()
    {
        return $this->role === 'pharmacy';
    }

    public function isRegularUser()
    {
        return $this->role === 'user';
    }

}
