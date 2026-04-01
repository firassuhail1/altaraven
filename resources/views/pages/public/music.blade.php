@extends('layouts.app')
@section('title', 'Music')

@section('content')

<section class="relative pt-32 pb-16 bg-ar-dark border-b border-ar-border overflow-hidden">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-ar-red to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">Discography</p>
        <h1 class="font-display text-6xl sm:text-8xl text-ar-white tracking-wide">Music</h1>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    @forelse($albums as $album)
        <div class="mb-20 last:mb-0">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                {{-- Cover --}}
                <div class="lg:col-span-3">
                    <a href="{{ route('music.show', $album->slug) }}" class="block group">
                        <div class="aspect-square overflow-hidden bg-ar-gray relative">
                            <img src="{{ $album->cover_url }}" alt="{{ $album->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0">
                            <div class="absolute inset-0 bg-ar-black/0 group-hover:bg-ar-black/20 transition-colors duration-300"></div>
                        </div>
                    </a>
                </div>

                {{-- Details + Embed --}}
                <div class="lg:col-span-9">
                    <div class="flex flex-wrap items-start gap-4 mb-4">
                        <span class="text-xs tracking-widest uppercase border border-ar-border text-ar-text2 px-2 py-1">
                            {{ strtoupper($album->type) }}
                        </span>
                        <span class="text-xs tracking-widest uppercase text-ar-text2">{{ $album->release_year }}</span>
                        @if($album->is_featured)
                            <span class="text-xs tracking-widest uppercase bg-ar-red/20 text-ar-red px-2 py-1">Featured</span>
                        @endif
                    </div>

                    <a href="{{ route('music.show', $album->slug) }}" class="group/title">
                        <h2 class="font-display text-4xl sm:text-5xl text-ar-white tracking-wide mb-4 group-hover/title:text-ar-red transition-colors duration-200">
                            {{ $album->title }}
                        </h2>
                    </a>

                    @if($album->description)
                        <p class="text-ar-text2 leading-relaxed mb-6 max-w-2xl">{{ $album->description }}</p>
                    @endif

                    {{-- Track list --}}
                    @if($album->tracks->count())
                        <div class="mb-6">
                            <p class="text-xs tracking-widest uppercase text-ar-text2 mb-3">{{ $album->tracks->count() }} Track{{ $album->tracks->count() > 1 ? 's' : '' }}</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                                @foreach($album->tracks->take(6) as $track)
                                    <div class="flex items-center gap-3 py-1.5 group/track">
                                        <span class="text-xs text-ar-text2 w-4 text-right">{{ $track->track_number }}</span>
                                        <span class="text-sm text-ar-text group-hover/track:text-ar-white transition-colors flex-1 truncate">{{ $track->title }}</span>
                                        @if($track->duration)
                                            <span class="text-xs text-ar-text2">{{ $track->duration }}</span>
                                        @endif
                                    </div>
                                @endforeach
                                @if($album->tracks->count() > 6)
                                    <div class="py-1.5 col-span-2">
                                        <span class="text-xs text-ar-text2">+{{ $album->tracks->count() - 6 }} more tracks</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Spotify embed --}}
                    @if($album->spotify_embed)
                        <div class="mb-6">
                            <iframe
                                src="{{ $album->spotify_embed }}"
                                width="100%"
                                height="{{ $album->tracks->count() > 1 ? '352' : '152' }}"
                                frameborder="0"
                                allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"
                            ></iframe>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-b border-ar-border mt-16"></div>
        </div>
    @empty
        <div class="text-center py-24">
            <p class="text-ar-text2 text-lg">No releases yet. Check back soon.</p>
        </div>
    @endforelse
</section>

@endsection
