<?php
// app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'file_path',
        'thumbnail_path',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Accessor untuk URL file dengan fallback placeholder
    public function getFileUrlAttribute()
    {
        if (!$this->file_path) {
            return $this->getPlaceholderUrl();
        }
        
        // Cek jika file exists di storage
        if (Storage::disk('public')->exists($this->file_path)) {
            return Storage::url($this->file_path);
        }
        
        return $this->getPlaceholderUrl();
    }

    // Accessor untuk URL thumbnail dengan fallback placeholder
    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail_path) {
            return $this->getPlaceholderUrl();
        }
        
        // Cek jika thumbnail exists di storage
        if (Storage::disk('public')->exists($this->thumbnail_path)) {
            return Storage::url($this->thumbnail_path);
        }
        
        return $this->getPlaceholderUrl();
    }

    // Method untuk mendapatkan placeholder URL berdasarkan type
    private function getPlaceholderUrl()
    {
        if ($this->type === 'photo') {
            // Placeholder untuk foto
            return 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
        } else {
            // Placeholder untuk video
            return 'https://images.unsplash.com/photo-1596388787377-2ab3f646b76a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
        }
    }

    // Scope untuk foto aktif
    public function scopeActivePhotos($query)
    {
        return $query->where('type', 'photo')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk video aktif - SESUAI DENGAN YANG DIMINTA
    public function scopeActiveVideos($query)
    {
        return $query->where('is_active', true)
                    ->where('type', 'video')
                    ->orderBy('order')
                    ->orderBy('created_at', 'desc');
    }

    // Method untuk menghapus file saat model dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gallery) {
            if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            if ($gallery->thumbnail_path && Storage::disk('public')->exists($gallery->thumbnail_path)) {
                Storage::disk('public')->delete($gallery->thumbnail_path);
            }
        });
    }
}