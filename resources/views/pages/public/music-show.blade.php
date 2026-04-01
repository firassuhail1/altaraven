@extends('layouts.app')
@section('title', $album->title)

@section('content')

<section class="relative pt-32 pb-0 overflow-hidden">
    <div class="absolute inset-0 bg-ar-dark z-0"></div>
    @if($album->cover_image)
        <div class="absolute inset-0 z-0">
            <img src="{{ $album->cover_url }}" alt="" class="w-full h-full object-cover opacity-10 blur-2xl scale-110">
            <div class="absolute inset-0 bg-gradient-to-b from-ar-dark/80 via-ar-dark/90 to-ar-black"></div>
        </div>
    @endif

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <a href="{{ route('music.index') }}" class="inline-flex items-center gap-2 text-ar-text2 hover:text-ar-white text-sm mb-10 transition-colors">
            ← Back to Music
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-3">
                <div class="aspect-square overflow-hidden shadow-2xl shadow-ar-black">
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="lg:col-span-9">
                <span class="text-xs tracking-widest uppercase border border-ar-border text-ar-text2 px-2 py-1">{{ strtoupper($album->type) }}</span>
                <h1 class="font-display text-5xl sm:text-7xl text-ar-white tracking-wide mt-4 mb-2">{{ $album->title }}</h1>
                <p class="text-ar-text2 mb-4">{{ $album->release_year }} · {{ $album->tracks->count() }} tracks</p>
                @if($album->description)
                    <p class="text-ar-text2 max-w-2xl leading-relaxed">{{ $album->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

        {{-- Track list --}}
        <div class="lg:col-span-3">
            <h2 class="font-display text-3xl text-ar-white tracking-wide mb-6">Tracklist</h2>
            <div x-data="{ activeTrack: null }" class="space-y-1">
                @foreach($album->tracks as $track)
                    <div
                        @click="activeTrack = activeTrack === {{ $track->id }} ? null : {{ $track->id }}"
                        class="group cursor-pointer"
                    >
                        <div class="flex items-center gap-4 px-4 py-3 hover:bg-ar-gray transition-colors duration-150"
                             :class="activeTrack === {{ $track->id }} ? 'bg-ar-gray border-l-2 border-ar-red' : 'border-l-2 border-transparent'">
                            <span class="text-xs text-ar-text2 w-4 text-right shrink-0">{{ $track->track_number }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-ar-text group-hover:text-ar-white transition-colors font-medium truncate">{{ $track->title }}</p>
                            </div>
                            @if($track->duration)
                                <span class="text-xs text-ar-text2 shrink-0">{{ $track->duration }}</span>
                            @endif
                            @if($track->spotify_track_id)
                                <svg class="w-3.5 h-3.5 text-ar-text2 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Inline Spotify embed --}}
                        @if($track->spotify_embed)
                            <div x-show="activeTrack === {{ $track->id }}" x-transition class="px-4 pb-3 bg-ar-gray border-l-2 border-ar-red">
                                <iframe
                                    src="{{ $track->spotify_embed }}"
                                    width="100%"
                                    height="80"
                                    frameborder="0"
                                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                    loading="lazy"
                                ></iframe>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Album player --}}
        <div class="lg:col-span-2">
            <h2 class="font-display text-3xl text-ar-white tracking-wide mb-6">Play Album</h2>
            @if($album->spotify_embed)
                <iframe
                    src="{{ $album->spotify_embed }}"
                    width="100%"
                    height="500"
                    frameborder="0"
                    allowfullscreen=""
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                    loading="lazy"
                ></iframe>
            @else
                <div class="bg-ar-gray p-8 text-center">
                    <p class="text-ar-text2 text-sm">Spotify player not available for this release.</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
