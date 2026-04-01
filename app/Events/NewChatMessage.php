<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ChatMessage $chatMessage)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("chat.{$this->chatMessage->chat_room_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }

    public function broadcastWith(): array
    {
        return [
            'id'          => $this->chatMessage->id,
            'sender_name' => $this->chatMessage->sender_name,
            'sender_type' => $this->chatMessage->sender_type,
            'message'     => $this->chatMessage->message,
            'attachment'  => $this->chatMessage->attachment_url,
            'created_at'  => $this->chatMessage->created_at->toISOString(),
        ];
    }
}
