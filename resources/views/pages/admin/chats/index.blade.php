{{-- chats/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Chats')

@section('content')

    <div class="bg-ar-dark border border-ar-border overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Subject</th>
                    <th>Order</th>
                    <th>Last Message</th>
                    <th>Status</th>
                    <th>Unread</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>
                            <p class="text-ar-white text-sm font-medium">{{ $room->customer_name }}</p>
                            <p class="text-ar-text2 text-xs">{{ $room->customer_email }}</p>
                        </td>
                        <td class="text-ar-text2 text-sm">{{ $room->subject }}</td>
                        <td>
                            @if ($room->order)
                                <a href="{{ route('admin.orders.show', $room->order) }}"
                                    class="text-xs text-ar-red hover:underline">
                                    {{ $room->order->order_number }}
                                </a>
                            @else
                                <span class="text-ar-text2 text-xs">—</span>
                            @endif
                        </td>
                        <td class="text-ar-text2 text-xs">
                            {{ $room->last_message_at ? $room->last_message_at->diffForHumans() : 'No messages' }}
                        </td>
                        <td>
                            <span class="{{ $room->status === 'open' ? 'badge-green' : 'badge-gray' }}">
                                {{ strtoupper($room->status) }}
                            </span>
                        </td>
                        <td>
                            @php $unread = $room->unreadByAdmin(); @endphp
                            @if ($unread)
                                <span
                                    class="bg-ar-red text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $unread }}</span>
                            @else
                                <span class="text-ar-text2 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.chats.show', $room) }}"
                                class="text-xs text-ar-text2 hover:text-ar-white transition-colors">Open →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-ar-text2 py-8">No chat rooms yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $rooms->links() }}</div>

@endsection
