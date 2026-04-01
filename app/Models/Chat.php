<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'is_read', 'read_at'];
    protected $casts = ['is_read' => 'boolean', 'read_at' => 'datetime'];

    public function markAsRead(): void
    {
        $this->update(['is_read' => true, 'read_at' => now()]);
    }
}

class ChatRoom extends Model
{
    protected $fillable = [
        'room_key', 'order_id', 'customer_name', 'customer_email',
        'subject', 'status', 'last_message_at',
    ];

    protected $casts = ['last_message_at' => 'datetime'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->room_key ??= Str::uuid());
    }

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
    }

    public function unreadByAdmin(): int
    {
        return $this->messages()->where('sender_type', 'customer')->where('is_read', false)->count();
    }
}

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id', 'user_id', 'sender_name', 'sender_type', 'message', 'attachment', 'is_read',
    ];

    protected $casts = ['is_read' => 'boolean'];

    public function room(): BelongsTo { return $this->belongsTo(ChatRoom::class, 'chat_room_id'); }
    public function admin(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }
}
