<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeDetails extends Model
{
    protected $guarded = [];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
