<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'svg_logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Get the SVG logo URL
     */
    public function getSvgLogoUrlAttribute()
    {
        if ($this->svg_logo) {
            return asset('storage/categories/' . $this->svg_logo);
        }
        return null;
    }

    /**
     * Scope to get only active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
