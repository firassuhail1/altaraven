@extends('layouts.app')
@section('title', 'Events')

@section('content')

<section class="relative pt-32 pb-16 bg-ar-dark border-b border-ar-border">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-ar-red to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">Live</p>
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
            <h1 class="font-display text-6xl sm:text-8xl text-ar-white tracking-wide">Events</h1>

            {{-- Filter tabs --}}
            <div class="flex gap-1 bg-ar-gray p-1">
                <a href="{{ route('events.index', ['filter' => 'upcoming']) }}"
                   class="px-5 py-2 text-xs tracking-widest uppercase font-medium transition-colors
                       {{ $filter === 'upcoming' ? 'bg-ar-red text-white' : 'text-ar-text2 hover:text-ar-white' }}">
                    Upcoming
                </a>
                <a href="{{ route('events.index', ['filter' => 'past']) }}"
                   class="px-5 py-2 text-xs tracking-widest uppercase font-medium transition-colors
                       {{ $filter === 'past' ? 'bg-ar-red text-white' : 'text-ar-text2 hover:text-ar-white' }}">
                    Past
                </a>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    @forelse($events as $event)
        <div class="group border-b border-ar-border py-8 first:pt-0 last:border-b-0 grid grid-cols-1 md:grid-cols-12 gap-6 items-center hover:bg-ar-dark/50 transition-colors px-4 -mx-4">

            {{-- Date block --}}
            <div class="md:col-span-2 text-center md:text-left">
                <div class="font-display text-5xl text-ar-white leading-none">
                    {{ $event->event_date->format('d') }}
                </div>
                <div class="text-sm text-ar-text2 tracking-wider uppercase mt-1">
                    {{ $event->event_date->translatedFormat('M Y') }}
                </div>
            </div>

            {{-- Poster --}}
            @if($event->poster_image)
                <div class="md:col-span-2">
                    <div class="aspect-video md:aspect-square overflow-hidden bg-ar-gray max-h-24">
                        <img src="{{ $event->poster_url }}" alt="{{ $event->name }}"
                             class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                </div>
            @endif

            {{-- Info --}}
            <div class="{{ $event->poster_image ? 'md:col-span-5' : 'md:col-span-7' }}">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xs tracking-widest uppercase px-2 py-0.5
                        {{ $event->status === 'upcoming' ? 'bg-ar-red/20 text-ar-red' : 'bg-ar-gray text-ar-text2' }}">
                        {{ strtoupper($event->status) }}
                    </span>
                </div>
                <h2 class="font-display text-2xl sm:text-3xl text-ar-white tracking-wide mb-2">{{ $event->name }}</h2>
                <div class="flex flex-wrap gap-4 text-sm text-ar-text2">
                    <span>{{ $event->venue ? $event->venue . ' · ' : '' }}{{ $event->city }}, {{ $event->country }}</span>
                    @if($event->event_time)
                        <span>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} WIB</span>
                    @endif
                </div>
                @if($event->description)
                    <p class="text-ar-text2 text-sm mt-2 line-clamp-2">{{ $event->description }}</p>
                @endif
            </div>

            {{-- CTA --}}
            <div class="md:col-span-3 flex flex-col gap-3 items-start md:items-end">
                @if($event->ticket_price)
                    <p class="text-ar-red font-semibold">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</p>
                @endif
                @if($event->ticket_url && $event->status === 'upcoming')
                    <a href="{{ $event->ticket_url }}" target="_blank"
                       class="px-5 py-2.5 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
                        Get Tickets
                    </a>
                @elseif($event->status === 'past')
                    <span class="text-xs text-ar-text2 tracking-widest uppercase">Event Ended</span>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-24">
            <p class="text-ar-text2 text-lg">
                {{ $filter === 'upcoming' ? 'No upcoming events at the moment. Stay tuned!' : 'No past events recorded yet.' }}
            </p>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($events->hasPages())
        <div class="mt-12 flex justify-center gap-2">
            {{ $events->appends(['filter' => $filter])->links('vendor.pagination.simple-tailwind') }}
        </div>
    @endif
</section>

@endsection
