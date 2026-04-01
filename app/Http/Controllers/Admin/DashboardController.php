<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_pending'  => Order::where('status', 'pending')->count(),
            'orders_total'    => Order::count(),
            'revenue'         => Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total'),
            'products'        => Product::active()->count(),
            'events_upcoming' => Event::upcoming()->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'active_chats'    => ChatRoom::where('status', 'open')->count(),
        ];

        $recentOrders = Order::with('items')->latest()->take(5)->get();
        $recentChats  = ChatRoom::with('latestMessage')
            ->where('status', 'open')
            ->orderByDesc('last_message_at')
            ->take(5)->get();

        return view('pages.admin.dashboard', compact('stats', 'recentOrders', 'recentChats'));
    }
}
