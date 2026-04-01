@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Back to Orders</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Order details --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Items --}}
        <div class="bg-ar-dark border border-ar-border">
            <div class="px-5 py-4 border-b border-ar-border">
                <h2 class="font-semibold text-ar-white">Items · {{ $order->order_number }}</h2>
            </div>
            <div class="divide-y divide-ar-border">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 px-5 py-4">
                        <div class="w-12 h-12 bg-ar-gray shrink-0">
                            @if($item->product)
                                <img src="{{ $item->product->primary_image_url }}" alt="" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-ar-white font-medium">{{ $item->product_name }}</p>
                            @if($item->variant_info)
                                <p class="text-xs text-ar-text2">{{ $item->variant_info }}</p>
                            @endif
                            <p class="text-xs text-ar-text2">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-ar-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="px-5 py-4 border-t border-ar-border bg-ar-gray/30 space-y-2">
                <div class="flex justify-between text-sm"><span class="text-ar-text2">Subtotal</span><span class="text-ar-white">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-ar-text2">Shipping</span><span class="text-ar-white">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div class="flex justify-between font-semibold border-t border-ar-border pt-2"><span class="text-ar-white">Total</span><span class="text-ar-red">{{ $order->formatted_total }}</span></div>
            </div>
        </div>

        {{-- Customer --}}
        <div class="bg-ar-dark border border-ar-border p-5">
            <h3 class="font-semibold text-ar-white mb-4">Customer & Shipping</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-ar-text2 mb-1">Name</p><p class="text-ar-white">{{ $order->customer_name }}</p></div>
                <div><p class="text-xs text-ar-text2 mb-1">Email</p><p class="text-ar-white">{{ $order->customer_email }}</p></div>
                <div><p class="text-xs text-ar-text2 mb-1">Phone</p><p class="text-ar-white">{{ $order->customer_phone ?? '—' }}</p></div>
                <div><p class="text-xs text-ar-text2 mb-1">Order Date</p><p class="text-ar-white">{{ $order->created_at->format('d M Y H:i') }}</p></div>
                <div class="col-span-2"><p class="text-xs text-ar-text2 mb-1">Shipping Address</p>
                    <p class="text-ar-white">{{ $order->shipping_address }}, {{ $order->shipping_city }}{{ $order->shipping_province ? ', ' . $order->shipping_province : '' }} {{ $order->shipping_postal_code }}</p>
                </div>
                @if($order->notes)
                    <div class="col-span-2"><p class="text-xs text-ar-text2 mb-1">Customer Notes</p><p class="text-ar-white">{{ $order->notes }}</p></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right: Status + Actions --}}
    <div class="space-y-6">

        {{-- Status update --}}
        <div class="bg-ar-dark border border-ar-border p-5">
            <h3 class="font-semibold text-ar-white mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <label class="text-xs text-ar-text2 tracking-widest uppercase mb-2 block">Status</label>
                    <select name="status" class="w-full bg-ar-gray border border-ar-border text-ar-white px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none">
                        @foreach(\App\Models\Order::STATUS_LABELS as $val => $label)
                            <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-ar-text2 tracking-widest uppercase mb-2 block">Tracking Number</label>
                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                           class="w-full bg-ar-gray border border-ar-border text-ar-white px-3 py-2 text-sm focus:border-ar-red focus:outline-none" placeholder="JNE, TIKI, etc.">
                </div>
                <div>
                    <label class="text-xs text-ar-text2 tracking-widest uppercase mb-2 block">Admin Notes</label>
                    <textarea name="admin_notes" rows="3"
                              class="w-full bg-ar-gray border border-ar-border text-ar-white px-3 py-2 text-sm focus:border-ar-red focus:outline-none resize-none"
                              placeholder="Internal notes...">{{ $order->admin_notes }}</textarea>
                </div>
                <button type="submit" class="w-full py-2.5 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
                    Update
                </button>
            </form>
        </div>

        {{-- Current status --}}
        <div class="bg-ar-dark border border-ar-border p-5">
            <h3 class="font-semibold text-ar-white mb-3">Status</h3>
            <span class="inline-block px-3 py-1.5 text-xs font-semibold tracking-wider uppercase
                bg-{{ $order->status_color }}-900/40 text-{{ $order->status_color }}-400 border border-{{ $order->status_color }}-800/50">
                {{ $order->status_label }}
            </span>
            @if($order->paid_at)
                <p class="text-xs text-ar-text2 mt-2">Paid: {{ $order->paid_at->format('d M Y H:i') }}</p>
            @endif
            @if($order->shipped_at)
                <p class="text-xs text-ar-text2">Shipped: {{ $order->shipped_at->format('d M Y H:i') }}</p>
            @endif
            @if($order->tracking_number)
                <p class="text-xs text-ar-text2">Tracking: {{ $order->tracking_number }}</p>
            @endif
        </div>

        {{-- Chat link --}}
        @if($order->chatRoom)
            <div class="bg-ar-dark border border-ar-border p-5">
                <h3 class="font-semibold text-ar-white mb-3">Customer Chat</h3>
                <a href="{{ route('admin.chats.show', $order->chatRoom) }}"
                   class="block w-full py-2.5 border border-ar-red text-ar-red hover:bg-ar-red hover:text-white text-xs font-semibold tracking-widest uppercase text-center transition-all">
                    Open Chat Room
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
