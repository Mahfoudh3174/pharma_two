<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $guarded = ['id'];

        public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
