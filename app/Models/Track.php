<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Track extends Model
{
    protected $fillable = [
        'album_id', 'title', 'slug', 'duration', 'track_number',
        'spotify_track_id', 'spotify_embed_url', 'cover_image',
        'release_year', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug ??= Str::slug($m->title . '-' . uniqid()));
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) return asset('storage/' . $this->cover_image);
        if ($this->album) return $this->album->cover_url;
        return asset('images/track-placeholder.jpg');
    }

    public function getSpotifyEmbedAttribute(): ?string
    {
        if ($this->spotify_embed_url) return $this->spotify_embed_url;
        if ($this->spotify_track_id) {
            return "https://open.spotify.com/embed/track/{$this->spotify_track_id}?utm_source=generator&theme=0";
        }
        return null;
    }
}
