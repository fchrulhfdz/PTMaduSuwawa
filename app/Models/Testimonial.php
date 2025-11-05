<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_title',
        'rating',
        'testimonial',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'integer'
    ];

    // Scope untuk testimonial aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk testimonial featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope untuk testimonial dengan rating tertentu
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where('customer_name', 'like', '%'.$search.'%')
                    ->orWhere('testimonial', 'like', '%'.$search.'%');
    }
}