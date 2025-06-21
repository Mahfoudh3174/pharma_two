<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

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
    //referance function
public static function generateReference()
{
    $letters = strtoupper(Str::random(3)); // Random 3 uppercase letters
    $numbers = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT); // Random 5-digit number with leading 0s
    return "REF-{$letters}{$numbers}";
}

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
