<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    protected $guarded=['id'];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
