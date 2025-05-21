<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    protected $guarded = [
        'id'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_medications')
            ->using(CommandeMedictation::class)
            ->withPivot('quantity', 'total_price')
            ->withTimestamps();
    }
}
