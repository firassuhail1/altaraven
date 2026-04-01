@extends('layouts.admin')
@section('title', 'Chat: ' . $chatRoom->subject)

@section('content')

<div class="flex flex-col h-[calc(100vh-8rem)]">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-4 pb-4 border-b border-ar-border">
        <div>
            <a href="{{ route('admin.chats.index') }}" class="text-xs text-ar-text2 hover:text-ar-white mb-2 inline-block">← Back to Chats</a>
            <h2 class="text-lg font-semibold text-ar-white">{{ $chatRoom->customer_name }}</h2>
            <p class="text-sm text-ar-text2">{{ $chatRoom->subject }} · {{ $chatRoom->customer_email }}</p>
            @if($chatRoom->order)
                <a href="{{ route('admin.orders.show', $chatRoom->order) }}" class="text-xs text-ar-red hover:text-ar-red2 mt-1 inline-block">
                    View Order #{{ $chatRoom->order->order_number }} →
                </a>
            @endif
        </div>
        <div class="flex gap-2 items-center">
            <span class="text-xs px-2 py-1 {{ $chatRoom->status === 'open' ? 'bg-green-900/40 text-green-400 border border-green-700' : 'bg-ar-gray text-ar-text2' }}">
                {{ strtoupper($chatRoom->status) }}
            </span>
            @if($chatRoom->status === 'open')
                <form action="{{ route('admin.chats.close', $chatRoom) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="text-xs px-3 py-1 border border-ar-border text-ar-text2 hover:border-ar-red hover:text-ar-red transition-colors">
                        Close Chat
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Messages --}}
    <div
        id="messages"
        x-data="adminChat({{ $chatRoom->id }})"
        x-init="init()"
        class="flex-1 overflow-y-auto space-y-3 pr-1"
    >
        @foreach($chatRoom->messages as $msg)
            <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%]">
                    <p class="text-xs text-ar-text2 mb-1 {{ $msg->sender_type === 'admin' ? 'text-right' : '' }}">
                        {{ $msg->sender_name }} · {{ $msg->created_at->format('d/m H:i') }}
                    </p>
                    <div class="px-4 py-2.5 text-sm leading-relaxed
                        {{ $msg->sender_type === 'admin'
                            ? 'bg-ar-red/20 border border-ar-red/30 text-ar-white'
                            : 'bg-ar-gray border border-ar-border text-ar-text' }}">
                        {{ $msg->message }}
                        @if($msg->attachment)
                            <a href="{{ $msg->attachment_url }}" target="_blank" class="block mt-1.5 text-xs text-ar-red hover:underline">📎 Attachment</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <template x-for="msg in newMessages" :key="msg.id">
            <div :class="msg.sender_type === 'admin' ? 'flex justify-end' : 'flex justify-start'">
                <div class="max-w-[70%]">
                    <p class="text-xs text-ar-text2 mb-1"
                       :class="msg.sender_type === 'admin' ? 'text-right' : ''"
                       x-text="msg.sender_name + ' · ' + new Date(msg.created_at).toLocaleString('id-ID', {day:'2-digit',month:'2-digit',hour:'2-digit',minute:'2-digit'})"></p>
                    <div class="px-4 py-2.5 text-sm leading-relaxed"
                         :class="msg.sender_type === 'admin'
                             ? 'bg-ar-red/20 border border-ar-red/30 text-ar-white'
                             : 'bg-ar-gray border border-ar-border text-ar-text'"
                         x-text="msg.message"></div>
                </div>
            </div>
        </template>

        <div id="bottom"></div>
    </div>

    {{-- Reply form --}}
    @if($chatRoom->status === 'open')
        <div class="border-t border-ar-border pt-4 mt-4" x-data="{ msg: '' }">
            <div class="flex gap-3">
                <input
                    type="text"
                    x-model="msg"
                    @keydown.enter.prevent="sendReply({{ $chatRoom->id }}, msg, () => { msg = '' })"
                    placeholder="Type your reply..."
                    class="flex-1 bg-ar-gray border border-ar-border text-ar-white placeholder-ar-text2 px-4 py-3 text-sm focus:border-ar-red focus:outline-none transition-colors"
                >
                <button
                    @click="sendReply({{ $chatRoom->id }}, msg, () => { msg = '' })"
                    class="px-5 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-wider uppercase transition-colors"
                >
                    Reply
                </button>
            </div>
            <p class="text-xs text-ar-text2 mt-2">You can share bank account number, QRIS, tracking info, etc.</p>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function adminChat(roomId) {
    return {
        newMessages: [],
        init() {
            document.getElementById('bottom')?.scrollIntoView();
            if (window.Echo) {
                window.Echo.channel(`chat.${roomId}`)
                    .listen('.new-message', (data) => {
                        this.newMessages.push(data);
                        this.$nextTick(() => document.getElementById('bottom')?.scrollIntoView({ behavior: 'smooth' }));
                    });
            }
        }
    }
}

async function sendReply(roomId, message, onSuccess) {
    if (!message.trim()) return;
    try {
        const res = await fetch(`/admin/chats/${roomId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message }),
        });
        if (res.ok) onSuccess();
    } catch (e) {
        console.error(e);
    }
}
</script>
@endpush
