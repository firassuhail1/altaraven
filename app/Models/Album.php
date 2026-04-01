<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Album extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'cover_image',
        'release_year', 'spotify_album_id', 'spotify_embed_url',
        'type', 'is_featured', 'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug ??= Str::slug($m->title));
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class)->orderBy('track_number');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/album-placeholder.jpg');
    }

    public function getSpotifyEmbedAttribute(): ?string
    {
        if ($this->spotify_embed_url) return $this->spotify_embed_url;
        if ($this->spotify_album_id) {
            return "https://open.spotify.com/embed/album/{$this->spotify_album_id}?utm_source=generator&theme=0";
        }
        return null;
    }

    public function scopeFeatured($q) { return $q->where('is_featured', true); }
}
