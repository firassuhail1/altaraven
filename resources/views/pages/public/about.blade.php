@extends('layouts.app')
@section('title', 'About')

@section('content')

{{-- Page hero --}}
<section class="relative pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-ar-dark to-ar-black z-0"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-ar-red to-transparent"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">Who We Are</p>
        <h1 class="font-display text-6xl sm:text-8xl text-ar-white tracking-wide">About</h1>
    </div>
</section>

{{-- Band info --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-20">
        <div class="lg:col-span-2">
            @if($bandInfo->description)
                <p class="text-xl text-ar-text font-light leading-relaxed mb-10 border-l-2 border-ar-red pl-6">
                    {{ $bandInfo->description }}
                </p>
            @endif

            @if($bandInfo->history)
                <div class="prose prose-invert max-w-none">
                    <h3 class="font-display text-3xl text-ar-white tracking-wide mb-6">Our Story</h3>
                    <div class="text-ar-text2 leading-relaxed space-y-4">
                        {!! nl2br(e($bandInfo->history)) !!}
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            @foreach([
                ['label' => 'Founded', 'value' => $bandInfo->founded_year],
                ['label' => 'Origin',  'value' => $bandInfo->origin],
                ['label' => 'Genre',   'value' => $bandInfo->genre],
                ['label' => 'Email',   'value' => $bandInfo->email, 'link' => 'mailto:' . $bandInfo->email],
            ] as $info)
                @if($info['value'])
                    <div class="border-b border-ar-border pb-4">
                        <p class="text-xs tracking-widest uppercase text-ar-text2 mb-1">{{ $info['label'] }}</p>
                        @if(isset($info['link']))
                            <a href="{{ $info['link'] }}" class="text-ar-white hover:text-ar-red transition-colors font-medium">{{ $info['value'] }}</a>
                        @else
                            <p class="text-ar-white font-medium">{{ $info['value'] }}</p>
                        @endif
                    </div>
                @endif
            @endforeach

            {{-- Social links --}}
            @if($bandInfo->social_links)
                <div>
                    <p class="text-xs tracking-widest uppercase text-ar-text2 mb-3">Follow Us</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($bandInfo->social_links as $platform => $url)
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                   class="px-3 py-1.5 border border-ar-border hover:border-ar-red text-ar-text2 hover:text-ar-red text-xs tracking-widest uppercase transition-all duration-200">
                                    {{ $platform }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Members --}}
@if($members->count())
<section class="bg-ar-dark border-t border-ar-border py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">The Band</p>
        <h2 class="font-display text-5xl text-ar-white tracking-wide mb-16">Members</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 lg:gap-8">
            @foreach($members as $member)
                <div class="group text-center">
                    <div class="relative aspect-[3/4] overflow-hidden mb-4 bg-ar-gray">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                             class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-ar-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-ar-black/80">
                            @if($member->bio)
                                <p class="text-xs text-ar-text2 leading-relaxed line-clamp-3">{{ $member->bio }}</p>
                            @endif
                        </div>
                    </div>
                    <h3 class="font-semibold text-ar-white text-sm">{{ $member->name }}</h3>
                    <p class="text-ar-red text-xs tracking-wider uppercase mt-0.5">{{ $member->role }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
