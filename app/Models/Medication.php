<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    protected $fillable = [
        'name',
        'category',
        'dosage_form',
        'strength',
    ];

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class)
            ->withPivot(['price', 'stock', 'last_restocked'])
            ->withTimestamps();
    }
}
