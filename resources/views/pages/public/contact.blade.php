{{-- contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Contact')

@section('content')

<section class="relative pt-32 pb-16 bg-ar-dark border-b border-ar-border">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-ar-red to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-ar-red text-xs tracking-[0.4em] uppercase font-medium mb-3">Get In Touch</p>
        <h1 class="font-display text-6xl sm:text-8xl text-ar-white tracking-wide">Contact</h1>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        {{-- Form --}}
        <div>
            <h2 class="font-display text-3xl text-ar-white tracking-wide mb-8">Send a Message</h2>

            @if(session('success'))
                <div class="bg-green-900/30 border border-green-700 text-green-300 px-4 py-3 rounded mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf
                @php
                    $input = 'w-full bg-ar-gray border border-ar-border text-ar-white placeholder-ar-text2 px-4 py-3 text-sm focus:border-ar-red focus:outline-none transition-colors';
                    $label = 'block text-xs tracking-widest uppercase text-ar-text2 mb-2';
                @endphp

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $label }}">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="{{ $input }}" placeholder="Your name">
                        @error('name') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $label }}">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="{{ $input }}" placeholder="you@example.com">
                        @error('email') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="{{ $label }}">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="{{ $input }}" placeholder="What's it about?">
                </div>

                <div>
                    <label class="{{ $label }}">Message *</label>
                    <textarea name="message" required rows="6" class="{{ $input }} resize-none" placeholder="Your message...">{{ old('message') }}</textarea>
                    @error('message') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="px-8 py-3.5 bg-ar-red hover:bg-ar-red2 text-white font-semibold text-sm tracking-widest uppercase transition-colors">
                    Send Message
                </button>
            </form>
        </div>

        {{-- Info --}}
        <div class="space-y-10">
            <div>
                <h2 class="font-display text-3xl text-ar-white tracking-wide mb-6">Connect</h2>
                @if($bandInfo->email)
                    <a href="mailto:{{ $bandInfo->email }}" class="text-ar-text2 hover:text-ar-red transition-colors text-sm">
                        {{ $bandInfo->email }}
                    </a>
                @endif
            </div>

            @if($bandInfo->social_links)
                <div>
                    <p class="text-xs tracking-widest uppercase text-ar-text2 mb-4">Social Media</p>
                    <div class="space-y-3">
                        @foreach($bandInfo->social_links as $platform => $url)
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                   class="flex items-center gap-3 text-ar-text2 hover:text-ar-white transition-colors group">
                                    <span class="w-2 h-2 bg-ar-red rounded-full group-hover:scale-150 transition-transform"></span>
                                    <span class="text-sm uppercase tracking-wider">{{ $platform }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
