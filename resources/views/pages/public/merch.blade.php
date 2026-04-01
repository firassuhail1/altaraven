@extends('layouts.app')
@section('title', 'Merch')

@section('content')

<section class="relative pt-32 pb-16 bg-ar-dark border-b border-ar-border">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-ar-red to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">Official Store</p>
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
            <h1 class="font-display text-6xl sm:text-8xl text-ar-white tracking-wide">Merch</h1>

            {{-- Category filter --}}
            @if($categories->count() > 1)
                <div class="flex flex-wrap gap-1 bg-ar-gray p-1">
                    <a href="{{ route('merch.index') }}"
                       class="px-4 py-2 text-xs tracking-widest uppercase font-medium transition-colors
                           {{ !request('category') ? 'bg-ar-red text-white' : 'text-ar-text2 hover:text-ar-white' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('merch.index', ['category' => $cat]) }}"
                           class="px-4 py-2 text-xs tracking-widest uppercase font-medium transition-colors
                               {{ request('category') === $cat ? 'bg-ar-red text-white' : 'text-ar-text2 hover:text-ar-white' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    @forelse($products as $product)
        @if($loop->first)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @endif

        <a href="{{ route('merch.show', $product->slug) }}" class="group block">
            <div class="aspect-square overflow-hidden bg-ar-gray mb-3 relative">
                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                {{-- Hover overlay --}}
                <div class="absolute inset-0 bg-ar-black/0 group-hover:bg-ar-black/30 transition-colors duration-300 flex items-center justify-center">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-white text-xs tracking-widest uppercase font-semibold bg-ar-red px-4 py-2">
                        View Details
                    </span>
                </div>
                {{-- Category badge --}}
                <div class="absolute top-3 left-3">
                    <span class="text-xs text-ar-text2 tracking-wider uppercase bg-ar-black/70 px-2 py-0.5">{{ $product->category }}</span>
                </div>
            </div>
            <h3 class="text-sm font-medium text-ar-white group-hover:text-ar-red transition-colors duration-200 truncate">
                {{ $product->name }}
            </h3>
            <p class="text-ar-red font-semibold text-sm mt-0.5">{{ $product->formatted_price }}</p>
        </a>

        @if($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-24">
            <p class="text-ar-text2 text-lg">No products available yet.</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="mt-12">
            {{ $products->links('vendor.pagination.simple-tailwind') }}
        </div>
    @endif
</section>

@endsection
