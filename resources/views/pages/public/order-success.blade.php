{{-- order-success.blade.php --}}
@extends('layouts.app')
@section('title', 'Order Placed!')

@section('content')
<div class="pt-28 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <div class="w-16 h-16 bg-ar-red/20 border border-ar-red rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-ar-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="font-display text-5xl text-ar-white tracking-wide mb-4">Order Placed!</h1>
        <p class="text-ar-text2 mb-3">
            Your order has been received. Our team will contact you shortly via chat to discuss payment and shipping details.
        </p>
        <p class="text-ar-text2 text-sm mb-10">
            Keep this page bookmarked — your chat room is linked below.
        </p>

        <div class="bg-ar-dark border border-ar-border p-6 mb-8 text-left">
            <p class="text-xs tracking-widest uppercase text-ar-text2 mb-2">Order Chat Room</p>
            <p class="text-ar-white font-medium mb-1">{{ $room->customer_name }}</p>
            <p class="text-ar-text2 text-sm mb-4">{{ $room->subject }}</p>
            <a href="{{ route('chat.room', $room->room_key) }}"
               class="block w-full py-3 bg-ar-red hover:bg-ar-red2 text-white text-center font-semibold text-sm tracking-widest uppercase transition-colors">
                Open Chat →
            </a>
            <p class="text-xs text-ar-text2 mt-3 text-center">Save this link to access your chat later</p>
        </div>

        <a href="{{ route('home') }}" class="text-ar-text2 hover:text-ar-white text-sm transition-colors">
            ← Back to Home
        </a>
    </div>
</div>
@endsection
