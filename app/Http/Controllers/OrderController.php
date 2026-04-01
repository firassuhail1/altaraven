<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request)
    {
        $room = ChatRoom::where('room_key', $request->room)->firstOrFail();
        return view('pages.public.order-success', compact('room'));
    }
}
