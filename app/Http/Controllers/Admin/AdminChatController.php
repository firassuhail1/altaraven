<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;

class AdminChatController extends Controller
{
    public function index()
    {
        $rooms = ChatRoom::with(['latestMessage', 'order'])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('pages.admin.chats.index', compact('rooms'));
    }

    public function show(ChatRoom $chatRoom)
    {
        $chatRoom->load(['messages', 'order']);
        $chatRoom->messages()->where('sender_type', 'customer')->update(['is_read' => true]);
        return view('pages.admin.chats.show', compact('chatRoom'));
    }

    public function close(ChatRoom $chatRoom)
    {
        $chatRoom->update(['status' => 'closed']);
        return back()->with('success', 'Chat room ditutup.');
    }
}
