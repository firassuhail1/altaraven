<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Full URL ke gambar.
     */
    // public function getImageUrlAttribute(): string
    // {
    //     return Storage::disk('public')->url($this->image_path);
    // }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/merch-placeholder.jpg');
    }

    /**
     * Scope: hanya yang aktif, urut by order.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
