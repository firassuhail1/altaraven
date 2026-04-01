@extends('layouts.app')
@section('title', 'Chat — ' . $room->subject)

@section('content')
<div class="pt-20 h-screen flex flex-col max-w-3xl mx-auto px-4">

    {{-- Header --}}
    <div class="py-5 border-b border-ar-border">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-ar-text2 tracking-widest uppercase mb-1">Order Chat</p>
                <h1 class="font-display text-2xl text-ar-white tracking-wide">{{ $room->subject }}</h1>
                @if($room->order)
                    <p class="text-xs text-ar-text2 mt-1">Order #{{ $room->order->order_number }}</p>
                @endif
            </div>
            <span class="text-xs px-2 py-1 {{ $room->status === 'open' ? 'bg-green-900/40 text-green-400 border border-green-700' : 'bg-ar-gray text-ar-text2' }}">
                {{ strtoupper($room->status) }}
            </span>
        </div>
        <p class="text-xs text-ar-text2 mt-3 bg-ar-dark border border-ar-border px-3 py-2">
            💬 Admin will share payment details (bank transfer / QRIS) here. Save this page URL to return to this chat.
        </p>
    </div>

    {{-- Messages --}}
    <div
        id="messages"
        class="flex-1 overflow-y-auto py-6 space-y-4"
        x-data="chatRoom('{{ $room->room_key }}', {{ $room->id }})"
        x-init="init()"
    >
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_type === 'customer' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%]">
                    <p class="text-xs text-ar-text2 mb-1 {{ $msg->sender_type === 'customer' ? 'text-right' : 'text-left' }}">
                        {{ $msg->sender_name }} · {{ $msg->created_at->format('H:i') }}
                    </p>
                    <div class="px-4 py-3 text-sm leading-relaxed
                        {{ $msg->sender_type === 'customer'
                            ? 'bg-ar-red/20 border border-ar-red/30 text-ar-white'
                            : 'bg-ar-gray border border-ar-border text-ar-text' }}">
                        @if($msg->message) {{ $msg->message }} @endif
                        @if($msg->attachment)
                            <a href="{{ $msg->attachment_url }}" target="_blank" class="block mt-2 text-xs text-ar-red hover:underline">
                                📎 View Attachment
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Realtime messages injected here --}}
        <template x-for="msg in newMessages" :key="msg.id">
            <div :class="msg.sender_type === 'customer' ? 'flex justify-end' : 'flex justify-start'">
                <div class="max-w-[75%]">
                    <p class="text-xs text-ar-text2 mb-1" :class="msg.sender_type === 'customer' ? 'text-right' : 'text-left'"
                       x-text="msg.sender_name + ' · ' + new Date(msg.created_at).toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'})"></p>
                    <div class="px-4 py-3 text-sm leading-relaxed"
                         :class="msg.sender_type === 'customer'
                             ? 'bg-ar-red/20 border border-ar-red/30 text-ar-white'
                             : 'bg-ar-gray border border-ar-border text-ar-text'"
                         x-text="msg.message">
                    </div>
                </div>
            </div>
        </template>

        <div id="bottom"></div>
    </div>

    {{-- Input --}}
    @if($room->status === 'open')
        <div class="border-t border-ar-border py-4">
            <form action="{{ route('chat.send', $room->room_key) }}" method="POST" class="flex gap-3">
                @csrf
                <input
                    type="text"
                    name="message"
                    placeholder="Type a message..."
                    autocomplete="off"
                    class="flex-1 bg-ar-gray border border-ar-border text-ar-white placeholder-ar-text2 px-4 py-3 text-sm focus:border-ar-red focus:outline-none transition-colors"
                >
                <button type="submit" class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-wider uppercase transition-colors shrink-0">
                    Send
                </button>
            </form>
        </div>
    @else
        <div class="border-t border-ar-border py-4 text-center">
            <p class="text-sm text-ar-text2">This chat has been closed.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function chatRoom(roomKey, roomId) {
    return {
        newMessages: [],
        init() {
            this.scrollToBottom();

            // Laravel Echo + Reverb
            if (window.Echo) {
                window.Echo.channel(`chat.${roomId}`)
                    .listen('.new-message', (data) => {
                        this.newMessages.push(data);
                        this.$nextTick(() => this.scrollToBottom());
                    });
            }

            // Fallback polling every 8s
            setInterval(() => this.poll(), 8000);
        },
        async poll() {
            try {
                const res = await fetch(`/chat/${roomId}/messages`);
                // If Echo is active, skip polling
                if (window.Echo) return;
                const data = await res.json();
                // Only show new ones
            } catch (e) {}
        },
        scrollToBottom() {
            this.$nextTick(() => {
                document.getElementById('bottom')?.scrollIntoView({ behavior: 'smooth' });
            });
        }
    }
}
</script>
@endpush
