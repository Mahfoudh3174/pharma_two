<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'longitude',
        'latitude',
        'address',
    ];
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
