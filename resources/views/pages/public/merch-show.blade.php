@extends('layouts.app')
@section('title', $product->name)

@section('content')

    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <a href="{{ route('merch.index') }}"
            class="inline-flex items-center gap-2 text-ar-text2 hover:text-ar-white text-sm mb-10 transition-colors">
            ← Back to Merch
        </a>

        <div x-data="{
            selectedVariant: null,
            activeImage: 0,
            get finalPrice() {
                if (!this.selectedVariant) return null;
                return this.selectedVariant.final_price;
            }
        }" class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

            {{-- Images --}}
            <div>
                {{-- Main image --}}
                <div class="aspect-square overflow-hidden bg-ar-gray mb-3">
                    @foreach ($product->images as $i => $img)
                        <img x-show="activeImage === {{ $i }}" src="{{ $img->url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                    @endforeach
                    @if ($product->images->isEmpty())
                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                    @endif
                </div>
                {{-- Thumbnails --}}
                @if ($product->images->count() > 1)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach ($product->images as $i => $img)
                            <button @click="activeImage = {{ $i }}"
                                :class="activeImage === {{ $i }} ? 'ring-2 ring-ar-red' :
                                    'opacity-60 hover:opacity-100'"
                                class="aspect-square overflow-hidden bg-ar-gray transition-all duration-150">
                                <img src="{{ $img->url }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product info --}}
            <div>
                <p class="text-xs text-ar-text2 tracking-widest uppercase mb-2">{{ $product->category }}</p>
                <h1 class="font-display text-4xl sm:text-5xl text-ar-white tracking-wide mb-4">{{ $product->name }}</h1>

                <div class="mb-6">
                    <p class="text-2xl font-semibold text-ar-red"
                        x-text="selectedVariant ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedVariant.final_price) : '{{ $product->formatted_price }}'">
                    </p>
                </div>

                @if ($product->description)
                    <p class="text-ar-text2 leading-relaxed mb-8">{{ $product->description }}</p>
                @endif

                {{-- Variant selector --}}
                @php
                    $activeVariants = $product->variants->where('is_active', true);

                    $variantsJson = $activeVariants->map(function ($v) {
                        return [
                            'id'          => $v->id,
                            'size'        => $v->size,
                            'type'        => $v->type,
                            'color'       => $v->color,
                            'color_hex'   => $v->color_hex,
                            'final_price' => (float) $v->final_price,
                            'in_stock'    => $v->isInStock(),
                            'label'       => $v->label,
                        ];
                    })->values();

                    $sizes = $activeVariants->pluck('size')->filter()->unique()->values();
                    $types = $activeVariants->pluck('type')->filter()->unique()->values();
                    $colors = $activeVariants->filter(fn($v) => $v->color)->unique('color')->values();
                @endphp

                {{-- Pass variants to Alpine --}}
                <div x-data="{
                    variants: {{ Js::from($variantsJson) }},
                    selectedSize: null,
                    selectedType: null,
                    selectedColor: null,
                    get matchedVariant() {
                        return this.variants.find(v =>
                            (!this.selectedSize  || v.size  === this.selectedSize)  &&
                            (!this.selectedType  || v.type  === this.selectedType)  &&
                            (!this.selectedColor || v.color === this.selectedColor)
                        ) ?? null;
                    },
                    get isInStock() { return this.matchedVariant?.in_stock ?? false; }
                }">

                    {{-- Size --}}
                    @if ($sizes->count())
                        <div class="mb-5">
                            <p class="text-xs tracking-widest uppercase text-ar-text2 mb-3">Size</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($sizes as $size)
                                    <button
                                        @click="selectedSize = selectedSize === '{{ $size }}' ? null : '{{ $size }}'"
                                        :class="selectedSize === '{{ $size }}' ? 'bg-ar-red border-ar-red text-white' :
                                            'border-ar-border text-ar-text2 hover:border-ar-text hover:text-ar-white'"
                                        class="w-12 h-12 border text-sm font-medium transition-all duration-150">{{ $size }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Type --}}
                    @if ($types->count())
                        <div class="mb-5">
                            <p class="text-xs tracking-widest uppercase text-ar-text2 mb-3">Type</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($types as $type)
                                    <button
                                        @click="selectedType = selectedType === '{{ $type }}' ? null : '{{ $type }}'"
                                        :class="selectedType === '{{ $type }}' ? 'bg-ar-red border-ar-red text-white' :
                                            'border-ar-border text-ar-text2 hover:border-ar-text hover:text-ar-white'"
                                        class="px-4 py-2 border text-sm font-medium transition-all duration-150">{{ $type }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Color --}}
                    @if ($colors->count())
                        <div class="mb-6">
                            <p class="text-xs tracking-widest uppercase text-ar-text2 mb-3">
                                Color: <span class="text-ar-white" x-text="selectedColor ?? '—'"></span>
                            </p>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($colors as $variant)
                                    <button
                                        @click="selectedColor = selectedColor === '{{ $variant->color }}' ? null : '{{ $variant->color }}'"
                                        :class="selectedColor === '{{ $variant->color }}' ?
                                            'ring-2 ring-ar-red ring-offset-2 ring-offset-ar-black' :
                                            'hover:ring-2 hover:ring-ar-text2 hover:ring-offset-2 hover:ring-offset-ar-black'"
                                        class="w-8 h-8 rounded-full border border-ar-border transition-all duration-150"
                                        style="background-color: {{ $variant->color_hex ?? '#333' }}"
                                        title="{{ $variant->color }}"></button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Debug (hapus jika sudah tidak diperlukan) --}}
                    {{-- <pre x-text="
                        'SelectedSize: ' + selectedSize +
                        ' SelectedType: ' + selectedType +
                        ' SelectedColor: ' + selectedColor +
                        ' MatchedVariant: ' + JSON.stringify(matchedVariant)
                    "></pre> --}}

                    {{-- Add to cart --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="variant_id" :value="matchedVariant?.id">
                        <input type="hidden" name="quantity" value="1">

                        <button type="submit" :disabled="!matchedVariant || !isInStock"
                            :class="matchedVariant && isInStock ?
                                'bg-ar-red hover:bg-ar-red2 text-white cursor-pointer animate-pulse-red' :
                                'bg-ar-gray text-ar-text2 cursor-not-allowed'"
                            class="w-full py-4 font-semibold text-sm tracking-widest uppercase transition-all duration-200 mb-3">
                            <span x-text="!matchedVariant ? 'Select Options' : (!isInStock ? 'Out of Stock' : 'Add to Cart')">
                                Add to Cart
                            </span>
                        </button>
                    </form>

                    {{-- Stock indicator --}}
                    <div x-show="matchedVariant" x-transition class="text-xs text-center">
                        <span x-show="isInStock" class="text-green-500">✓ In Stock</span>
                        <span x-show="!isInStock" class="text-ar-red">✗ Out of Stock</span>
                    </div>

                </div>

                {{-- Meta --}}
                <div class="border-t border-ar-border mt-8 pt-6 grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-ar-text2 mb-1">Category</p>
                        <p class="text-ar-white">{{ ucfirst($product->category) }}</p>
                    </div>
                    <div>
                        <p class="text-ar-text2 mb-1">Variants</p>
                        <p class="text-ar-white">{{ $product->variants->count() }} options</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection