<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $guarded = ['id','status'];

        public function medications()
    {
        return $this->hasMany(Medication::class);
    }
    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
