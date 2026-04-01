<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    protected $fillable = [
        'room_key',
        'order_id',
        'customer_name',
        'customer_email',
        'subject',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            $m->room_key = $m->room_key ?? (string) Str::uuid();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
    }

    public function unreadByAdmin(): int
    {
        return $this->messages()
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->count();
    }
}
