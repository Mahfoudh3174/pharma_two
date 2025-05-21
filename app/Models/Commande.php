<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        "user_id",
        "date",
        "status",
        "amount",
        "reject_reason",
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function medications(){
        return $this->hasMany(Medication::class,'commande_medications')
        ->using(CommandeMedictation::class)
        ->withPivot('quantity', 'total_price')
        ->withTimestamps()
 
        ;
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
