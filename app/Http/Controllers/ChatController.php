<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Customer: view their chat room
    public function room(string $roomKey)
    {
        $room     = ChatRoom::with('messages', 'order')->where('room_key', $roomKey)->firstOrFail();
        $messages = $room->messages;

        // Mark admin messages as read
        $room->messages()->where('sender_type', 'admin')->update(['is_read' => true]);

        return view('pages.public.chat', compact('room', 'messages'));
    }

    // Customer: send message
    public function send(Request $request, string $roomKey)
    {
        $room = ChatRoom::where('room_key', $roomKey)->firstOrFail();

        $request->validate([
            'message'    => 'required_without:attachment|string|max:2000|nullable',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-attachments', 'public');
        }

        $msg = ChatMessage::create([
            'chat_room_id' => $room->id,
            'sender_name'  => $room->customer_name,
            'sender_type'  => 'customer',
            'message'      => $request->message ?? '',
            'attachment'   => $attachmentPath,
        ]);

        $room->update(['last_message_at' => now()]);

        broadcast(new NewChatMessage($msg))->toOthers();

        if ($request->expectsJson()) {
            return response()->json(['message' => $msg->load([])]);
        }

        return back();
    }

    // Admin: send reply
    public function adminReply(Request $request, int $roomId)
    {
        $room = ChatRoom::findOrFail($roomId);

        $request->validate([
            'message'    => 'required_without:attachment|string|max:2000|nullable',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-attachments', 'public');
        }

        $msg = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id'      => auth()->id(),
            'sender_name'  => auth()->user()->name,
            'sender_type'  => 'admin',
            'message'      => $request->message ?? '',
            'attachment'   => $attachmentPath,
        ]);

        $room->update(['last_message_at' => now()]);

        broadcast(new NewChatMessage($msg))->toOthers();

        return response()->json(['message' => $msg]);
    }

    // Admin: get messages for a room (polling fallback)
    public function messages(int $roomId)
    {
        $room     = ChatRoom::findOrFail($roomId);
        $messages = $room->messages()->orderBy('created_at')->get()->map(fn($m) => [
            'id'          => $m->id,
            'sender_name' => $m->sender_name,
            'sender_type' => $m->sender_type,
            'message'     => $m->message,
            'attachment'  => $m->attachment_url,
            'created_at'  => $m->created_at->format('H:i'),
        ]);

        // Mark customer messages as read
        $room->messages()->where('sender_type', 'customer')->update(['is_read' => true]);

        return response()->json($messages);
    }
}
