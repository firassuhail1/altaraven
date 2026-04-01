{{-- checkout.blade.php --}}
@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="pt-28 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <h1 class="font-display text-5xl sm:text-6xl text-ar-white tracking-wide mb-12">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

            {{-- Customer form --}}
            <div class="lg:col-span-3 space-y-5">
                <h2 class="font-display text-2xl text-ar-white tracking-wide mb-6">Shipping Info</h2>

                @php
                    $inputClass = 'w-full bg-ar-gray border border-ar-border text-ar-white placeholder-ar-text2 px-4 py-3 text-sm focus:border-ar-red focus:outline-none transition-colors';
                    $labelClass = 'block text-xs tracking-widest uppercase text-ar-text2 mb-2';
                @endphp

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">Full Name *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="{{ $inputClass }}" placeholder="John Doe">
                        @error('customer_name') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Phone</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="{{ $inputClass }}" placeholder="+62...">
                    </div>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Email *</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" required class="{{ $inputClass }}" placeholder="you@example.com">
                    @error('customer_email') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Address *</label>
                    <textarea name="shipping_address" required rows="3" class="{{ $inputClass }} resize-none" placeholder="Jl. ...">{{ old('shipping_address') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">City *</label>
                        <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Province</label>
                        <input type="text" name="shipping_province" value="{{ old('shipping_province') }}" class="{{ $inputClass }}">
                    </div>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Postal Code</label>
                    <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="{{ $inputClass }} w-32">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Order Notes</label>
                    <textarea name="notes" rows="2" class="{{ $inputClass }} resize-none" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Order summary --}}
            <div class="lg:col-span-2">
                <h2 class="font-display text-2xl text-ar-white tracking-wide mb-6">Order Summary</h2>
                <div class="bg-ar-dark border border-ar-border p-6 space-y-4">
                    @foreach($items as $item)
                        <div class="flex gap-3 items-start">
                            <img src="{{ $item['image'] }}" alt="" class="w-12 h-12 object-cover bg-ar-gray shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-ar-white font-medium truncate">{{ $item['product_name'] }}</p>
                                @if($item['variant_info'])
                                    <p class="text-xs text-ar-text2">{{ $item['variant_info'] }}</p>
                                @endif
                                <p class="text-xs text-ar-text2">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-sm text-ar-white shrink-0">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach

                    <div class="border-t border-ar-border pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-ar-text2">Subtotal</span>
                            <span class="text-ar-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-ar-text2">Shipping</span>
                            <span class="text-ar-text2">Discussed via chat</span>
                        </div>
                        <div class="flex justify-between font-semibold text-base border-t border-ar-border pt-2 mt-2">
                            <span class="text-ar-white">Total</span>
                            <span class="text-ar-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-ar-text2 border-t border-ar-border pt-4 leading-relaxed">
                        Payment info (rekening / QRIS) will be shared by admin via chat after order is placed.
                    </p>

                    <button type="submit" class="w-full py-3.5 bg-ar-red hover:bg-ar-red2 text-white font-semibold text-sm tracking-widest uppercase transition-colors mt-2">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
