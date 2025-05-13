<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
    ];

        public function medications()
    {
        return $this->belongsToMany(Medication::class)
            ->withPivot(['price', 'stock'])
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
