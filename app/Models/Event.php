<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'event_date', 'event_time',
        'venue', 'city', 'country', 'ticket_url', 'poster_image',
        'status', 'is_featured', 'ticket_price',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'is_featured' => 'boolean',
        'ticket_price'=> 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug ??= Str::slug($m->name . '-' . $m->event_date));
        static::saving(function ($m) {
            // auto-update status based on date
            if ($m->event_date && $m->event_date->isPast() && $m->status === 'upcoming') {
                $m->status = 'past';
            }
        });
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster_image
            ? asset('storage/' . $this->poster_image)
            : asset('images/event-placeholder.jpg');
    }

    public function scopeUpcoming($q) { return $q->where('status', 'upcoming')->orderBy('event_date'); }
    public function scopePast($q)     { return $q->where('status', 'past')->orderByDesc('event_date'); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
}
