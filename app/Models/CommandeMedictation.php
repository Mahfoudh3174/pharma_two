<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommandeMedictation extends Pivot
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'quantity',
        'total_price',
    ];
   protected $table = 'commande_medications';

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
    
}
