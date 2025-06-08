<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function medications(){
        return $this->belongsToMany(Medication::class,'commande_medications')
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
