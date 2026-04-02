{{-- cart.blade.php --}}
@extends('layouts.app')
@section('title', 'Cart')

@push('styles')
    <style>
        /* Chrome, Safari, Edge */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('content')
    <div class="pt-28 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <h1 class="font-display text-5xl sm:text-6xl text-ar-white tracking-wide mb-12">Your Cart</h1>

        @if (empty($items))
            <div class="text-center py-24">
                <p class="text-ar-text2 text-lg mb-6">Your cart is empty.</p>
                <a href="{{ route('merch.index') }}"
                    class="px-6 py-3 bg-ar-red text-white text-sm font-semibold tracking-widest uppercase">Browse Merch</a>
            </div>
        @else
            <div class="divide-y divide-ar-border">
                @foreach ($items as $key => $item)
                    <div class="py-6 grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-2 sm:col-span-1">
                            <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}"
                                class="w-16 h-16 object-cover bg-ar-gray">
                        </div>
                        <div class="col-span-6 sm:col-span-7">
                            <h3 class="font-medium text-ar-white">{{ $item['product_name'] }}</h3>
                            @if ($item['variant_info'])
                                <p class="text-xs text-ar-text2 mt-0.5">{{ $item['variant_info'] }}</p>
                            @endif
                            <p class="text-sm text-ar-red mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            {{-- <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                                   class="w-14 bg-ar-gray border border-ar-border text-ar-white text-sm text-center py-1.5 focus:border-ar-red outline-none">
                            <button type="submit" class="text-xs text-ar-text2 hover:text-ar-white">↵</button>
                        </form> --}}
                            <div class="col-span-2 sm:col-span-2">
                                <div class="flex items-center gap-1">
                                    <button type="button" onclick="changeQty('{{ $key }}', -1)"
                                        style="width: 29px; height: 29px;"
                                        class="bg-ar-gray border border-ar-border text-ar-white hover:border-ar-red transition-colors text-sm flex items-center justify-center">
                                        −
                                    </button>
                                    <input type="number" id="qty-{{ $key }}" value="{{ $item['quantity'] }}"
                                        min="1" max="99" onchange="scheduleUpdate('{{ $key }}')"
                                        oninput="scheduleUpdate('{{ $key }}')" style="width: 50px;"
                                        class="bg-ar-gray border border-ar-border text-ar-white text-sm text-center py-1 focus:border-ar-red outline-none">
                                    <button type="button" onclick="changeQty('{{ $key }}', 1)"
                                        style="width: 29px; height: 29px;"
                                        class="bg-ar-gray border border-ar-border text-ar-white hover:border-ar-red transition-colors text-sm flex items-center justify-center">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1 text-right">
                            <p class="text-sm font-semibold text-ar-white hidden sm:block"
                                id="subtotal-{{ $key }}">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                            <form action="{{ route('cart.remove', $key) }}" method="POST" class="inline mt-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-ar-text2 hover:text-ar-red transition-colors text-xs">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total + CTA --}}
            <div
                class="border-t border-ar-border mt-6 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                    <p class="text-ar-text2 text-sm">Total</p>
                    <p class="font-display text-3xl text-ar-white tracking-wide" id="cart-total">Rp
                        {{ number_format($total, 0, ',', '.') }}</p>
                    <p class="text-xs text-ar-text2 mt-1">Shipping calculated at checkout</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('merch.index') }}"
                        class="px-5 py-3 border border-ar-border text-ar-text2 hover:text-ar-white text-sm tracking-widest uppercase transition-colors">
                        Continue Shopping
                    </a>
                    <a href="{{ route('checkout.index') }}"
                        class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white font-semibold text-sm tracking-widest uppercase transition-colors">
                        Checkout →
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const debounceTimers = {};

            function scheduleUpdate(key) {
                clearTimeout(debounceTimers[key]);
                debounceTimers[key] = setTimeout(() => sendUpdate(key), 2000);
            }

            function changeQty(key, delta) {
                const input = document.getElementById('qty-' + key);
                let newVal = parseInt(input.value) + delta;
                if (newVal < 1) newVal = 1;
                if (newVal > 99) newVal = 99;
                input.value = newVal;
                scheduleUpdate(key);
            }

            function sendUpdate(key) {
                const qty = document.getElementById('qty-' + key).value;

                fetch(`/cart/${key}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'PATCH',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            quantity: qty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update total keseluruhan
                            document.getElementById('cart-total').textContent = 'Rp ' + data.total;

                            // Update subtotal per item
                            const subtotalEl = document.getElementById('subtotal-' + key);
                            if (subtotalEl) subtotalEl.textContent = 'Rp ' + data.subtotal;

                            // Highlight input hijau sebentar
                            const input = document.getElementById('qty-' + key);
                            input.style.borderColor = '#22c55e';
                            setTimeout(() => input.style.borderColor = '', 1000);
                        }
                    });
            }
        </script>
    @endpush
@endsection
