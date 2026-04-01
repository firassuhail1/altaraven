@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $statCards = [
                [
                    'label' => 'Pending Orders',
                    'value' => $stats['orders_pending'],
                    'icon' =>
                        'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    'color' => 'text-yellow-400',
                    'route' => 'admin.orders.index',
                ],
                [
                    'label' => 'Total Revenue',
                    'value' => 'Rp ' . number_format($stats['revenue'], 0, ',', '.'),
                    'icon' =>
                        'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'text-green-400',
                    'route' => 'admin.orders.index',
                ],
                [
                    'label' => 'Active Chats',
                    'value' => $stats['active_chats'],
                    'icon' =>
                        'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                    'color' => 'text-blue-400',
                    'route' => 'admin.chats.index',
                ],
                [
                    'label' => 'Unread Messages',
                    'value' => $stats['unread_messages'],
                    'icon' =>
                        'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    'color' => 'text-ar-red',
                    'route' => 'admin.contact-messages.index',
                ],
            ];
        @endphp

        @foreach ($statCards as $card)
            <a href="{{ route($card['route']) }}"
                class="bg-ar-dark border border-ar-border p-5 hover:border-ar-red transition-colors group">
                <div class="flex items-start justify-between mb-3">
                    <svg class="w-5 h-5 {{ $card['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}" />
                    </svg>
                </div>
                <p class="font-display text-2xl lg:text-3xl text-ar-white tracking-wide">{{ $card['value'] }}</p>
                <p class="text-xs text-ar-text2 mt-1 tracking-wider uppercase">{{ $card['label'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Orders --}}
        <div class="bg-ar-dark border border-ar-border">
            <div class="px-5 py-4 border-b border-ar-border flex justify-between items-center">
                <h2 class="font-semibold text-ar-white text-sm">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-xs text-ar-text2 hover:text-ar-red transition-colors">View all →</a>
            </div>
            <div class="divide-y divide-ar-border">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="flex items-center gap-4 px-5 py-3 hover:bg-ar-gray transition-colors group">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-ar-white font-medium">{{ $order->order_number }}</p>
                            <p class="text-xs text-ar-text2 truncate">{{ $order->customer_name }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm text-ar-white">{{ $order->formatted_total }}</p>
                            <span
                                class="text-xs px-1.5 py-0.5 bg-{{ $order->status_color }}-900/40 text-{{ $order->status_color }}-400 border border-{{ $order->status_color }}-800/50">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="px-5 py-6 text-sm text-ar-text2 text-center">No orders yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Active Chats --}}
        <div class="bg-ar-dark border border-ar-border">
            <div class="px-5 py-4 border-b border-ar-border flex justify-between items-center">
                <h2 class="font-semibold text-ar-white text-sm">Active Chats</h2>
                <a href="{{ route('admin.chats.index') }}"
                    class="text-xs text-ar-text2 hover:text-ar-red transition-colors">View all →</a>
            </div>
            <div class="divide-y divide-ar-border">
                @forelse($recentChats as $chat)
                    <a href="{{ route('admin.chats.show', $chat) }}"
                        class="flex items-start gap-4 px-5 py-3 hover:bg-ar-gray transition-colors">
                        <div
                            class="w-8 h-8 bg-ar-red/20 border border-ar-red/30 rounded-full flex items-center justify-center shrink-0 text-ar-red text-xs font-bold">
                            {{ strtoupper(substr($chat->customer_name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-ar-white font-medium">{{ $chat->customer_name }}</p>
                            <p class="text-xs text-ar-text2 truncate">{{ $chat->subject }}</p>
                            @if ($chat->latestMessage)
                                <p class="text-xs text-ar-text2 truncate mt-0.5">{{ $chat->latestMessage->message }}</p>
                            @endif
                        </div>
                        @php $unread = $chat->unreadByAdmin(); @endphp
                        @if ($unread)
                            <span
                                class="shrink-0 bg-ar-red text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                @empty
                    <p class="px-5 py-6 text-sm text-ar-text2 text-center">No active chats.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
