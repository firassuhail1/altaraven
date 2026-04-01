{{-- band-info.blade.php --}}
@extends('layouts.admin')
@section('title', 'Band Info')

@section('content')

@php
    $input = 'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
    $label = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
@endphp

<div class="max-w-3xl">
    <div class="bg-ar-dark border border-ar-border p-6">
        <form action="{{ route('admin.band-info.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="{{ $label }}">Band Name *</label>
                    <input type="text" name="band_name" value="{{ old('band_name', $bandInfo->band_name) }}" required class="{{ $input }}">
                </div>
                <div>
                    <label class="{{ $label }}">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $bandInfo->tagline) }}" class="{{ $input }}" placeholder="One powerful line">
                </div>
            </div>

            <div>
                <label class="{{ $label }}">Short Description</label>
                <textarea name="description" rows="3" class="{{ $input }} resize-none" placeholder="Short intro shown on About page">{{ old('description', $bandInfo->description) }}</textarea>
            </div>

            <div>
                <label class="{{ $label }}">Band History</label>
                <textarea name="history" rows="8" class="{{ $input }} resize-none" placeholder="Full history story...">{{ old('history', $bandInfo->history) }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="{{ $label }}">Founded Year</label>
                    <input type="text" name="founded_year" value="{{ old('founded_year', $bandInfo->founded_year) }}" class="{{ $input }}" maxlength="4" placeholder="2018">
                </div>
                <div>
                    <label class="{{ $label }}">Genre</label>
                    <input type="text" name="genre" value="{{ old('genre', $bandInfo->genre) }}" class="{{ $input }}" placeholder="Metal">
                </div>
                <div>
                    <label class="{{ $label }}">Origin</label>
                    <input type="text" name="origin" value="{{ old('origin', $bandInfo->origin) }}" class="{{ $input }}" placeholder="Jakarta, Indonesia">
                </div>
            </div>

            <div>
                <label class="{{ $label }}">Contact Email</label>
                <input type="email" name="email" value="{{ old('email', $bandInfo->email) }}" class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">Hero Video URL (YouTube / direct link)</label>
                <input type="url" name="hero_video" value="{{ old('hero_video', $bandInfo->hero_video) }}" class="{{ $input }}" placeholder="https://...">
            </div>

            <div>
                <label class="{{ $label }}">Hero Image</label>
                @if($bandInfo->hero_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $bandInfo->hero_image) }}" alt="Hero" class="h-32 object-cover">
                    </div>
                @endif
                <input type="file" name="hero_image" accept="image/*" class="{{ $input }} py-2 file:mr-3 file:bg-ar-red file:border-0 file:text-white file:text-xs file:px-3 file:py-1 file:cursor-pointer">
            </div>

            {{-- Social links --}}
            <div>
                <label class="{{ $label }} mb-3">Social Links</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(['instagram' => 'Instagram', 'spotify' => 'Spotify', 'youtube' => 'YouTube', 'facebook' => 'Facebook', 'tiktok' => 'TikTok'] as $key => $platform)
                        <div>
                            <label class="block text-xs text-ar-text2 mb-1">{{ $platform }}</label>
                            <input type="url" name="social_links[{{ $key }}]"
                                   value="{{ old('social_links.' . $key, $bandInfo->social_links[$key] ?? '') }}"
                                   class="{{ $input }}" placeholder="https://...">
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                Save Band Info
            </button>
        </form>
    </div>
</div>

@endsection
