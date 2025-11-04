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
        'rating' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Scope untuk testimonial aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk testimonial featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk testimonial dengan rating tertentu
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Get formatted rating stars
     */
    public function getStarsAttribute()
    {
        return str_repeat('⭐', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Get short testimonial (for preview)
     */
    public function getShortTestimonialAttribute()
    {
        return strlen($this->testimonial) > 100 
            ? substr($this->testimonial, 0, 100) . '...' 
            : $this->testimonial;
    }
}