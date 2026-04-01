@extends('layouts.admin')
@section('title', $album->exists ? 'Edit: ' . $album->title : 'Add Album')

@section('content')

@php
    $isEdit = $album->exists;
    $action = $isEdit ? route('admin.music.update', $album) : route('admin.music.store');
    $input  = 'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
    $label  = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
@endphp

<div class="mb-6">
    <a href="{{ route('admin.music.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Music</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Album form --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-ar-dark border border-ar-border p-6">
            <h2 class="font-semibold text-ar-white mb-5">Album / Release Info</h2>

            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div>
                    <label class="{{ $label }}">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $album->title) }}" required class="{{ $input }}">
                    @error('title') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $label }}">Description</label>
                    <textarea name="description" rows="3" class="{{ $input }} resize-none">{{ old('description', $album->description) }}</textarea>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="{{ $label }}">Type *</label>
                        <select name="type" class="{{ $input }}">
                            @foreach(['album' => 'Album', 'ep' => 'EP', 'single' => 'Single'] as $val => $lbl)
                                <option value="{{ $val }}" {{ old('type', $album->type ?? 'album') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="{{ $label }}">Release Year *</label>
                        <input type="number" name="release_year" value="{{ old('release_year', $album->release_year ?? date('Y')) }}" required class="{{ $input }}" min="1900" max="{{ date('Y') + 1 }}">
                    </div>
                    <div>
                        <label class="{{ $label }}">Sort Order</label>
                        <input type="number" name="order" value="{{ old('order', $album->order ?? 0) }}" class="{{ $input }}" min="0">
                    </div>
                </div>

                {{-- Spotify integration --}}
                <div x-data="{ searching: false, results: [] }" class="space-y-3">
                    <div>
                        <label class="{{ $label }}">Spotify Album ID</label>
                        <div class="flex gap-2">
                            <input type="text" name="spotify_album_id" id="spotify_album_id"
                                   value="{{ old('spotify_album_id', $album->spotify_album_id) }}"
                                   class="{{ $input }}" placeholder="e.g. 3T4tUhGYeRNVUGevb0wThu">
                            <button type="button"
                                    @click="
                                        searching = true;
                                        const q = document.getElementById('spotify_q').value;
                                        fetch(`{{ route('admin.music.spotify.search') }}?q=${encodeURIComponent(q)}`)
                                            .then(r => r.json())
                                            .then(d => { results = d; searching = false; });
                                    "
                                    class="px-3 py-2 bg-green-900/40 border border-green-700 text-green-400 hover:bg-green-800/40 text-xs whitespace-nowrap transition-colors">
                                Search Spotify
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <input type="text" id="spotify_q" class="{{ $input }}" placeholder="Search album on Spotify..." @keydown.enter.prevent="">
                    </div>

                    {{-- Spotify search results --}}
                    <div x-show="results.length" class="border border-ar-border bg-ar-gray/30 divide-y divide-ar-border max-h-64 overflow-y-auto">
                        <template x-for="result in results" :key="result.id">
                            <div class="flex items-center gap-3 p-3 hover:bg-ar-gray cursor-pointer transition-colors"
                                 @click="
                                     document.getElementById('spotify_album_id').value = result.id;
                                     results = [];
                                 ">
                                <img :src="result.images?.[0]?.url" class="w-10 h-10 object-cover" :alt="result.name">
                                <div>
                                    <p class="text-sm text-ar-white font-medium" x-text="result.name"></p>
                                    <p class="text-xs text-ar-text2" x-text="result.release_date"></p>
                                </div>
                                <span class="ml-auto text-xs text-green-400">Select →</span>
                            </div>
                        </template>
                    </div>

                    <div>
                        <label class="{{ $label }}">Or paste Spotify Embed URL</label>
                        <input type="url" name="spotify_embed_url" value="{{ old('spotify_embed_url', $album->spotify_embed_url) }}"
                               class="{{ $input }}" placeholder="https://open.spotify.com/embed/album/...">
                        <p class="text-xs text-ar-text2 mt-1">Paste the Spotify embed link directly (optional, overrides Album ID).</p>
                    </div>
                </div>

                <div>
                    <label class="{{ $label }}">Cover Image</label>
                    @if($isEdit && $album->cover_image)
                        <div class="mb-3">
                            <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-24 h-24 object-cover">
                        </div>
                    @endif
                    <input type="file" name="cover_image" accept="image/*" class="{{ $input }} py-2 file:mr-3 file:bg-ar-red file:border-0 file:text-white file:text-xs file:px-3 file:py-1 file:cursor-pointer">
                </div>

                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $album->is_featured ?? false) ? 'checked' : '' }} class="accent-ar-red">
                        <span class="text-sm text-ar-text2">Featured on homepage</span>
                    </label>
                </div>

                <button type="submit" class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                    {{ $isEdit ? 'Save Album' : 'Create Album' }}
                </button>
            </form>
        </div>

        {{-- Tracks (only in edit mode) --}}
        @if($isEdit)
            <div class="bg-ar-dark border border-ar-border p-6">
                <h2 class="font-semibold text-ar-white mb-5">Tracks</h2>

                {{-- Existing tracks --}}
                @if($album->tracks->count())
                    <div class="divide-y divide-ar-border mb-5">
                        @foreach($album->tracks as $track)
                            <div class="flex items-center gap-4 py-3">
                                <span class="text-xs text-ar-text2 w-5 text-right">{{ $track->track_number }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-ar-white font-medium">{{ $track->title }}</p>
                                    @if($track->spotify_track_id)
                                        <p class="text-xs text-green-400">♫ Spotify linked</p>
                                    @endif
                                </div>
                                @if($track->duration)<span class="text-xs text-ar-text2">{{ $track->duration }}</span>@endif
                                <form action="{{ route('admin.music.tracks.destroy', $track) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-ar-text2 hover:text-ar-red transition-colors ml-2">✕</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Add track --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="text-xs px-4 py-2 border border-ar-border text-ar-text2 hover:border-ar-red hover:text-ar-white transition-colors">
                        + Add Track
                    </button>
                    <div x-show="open" x-transition class="mt-4 border border-ar-border p-4 bg-ar-gray/20">
                        <form action="{{ route('admin.music.tracks.store', $album) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div class="col-span-2 sm:col-span-3">
                                    <label class="{{ $label }}">Track Title *</label>
                                    <input type="text" name="title" required class="{{ $input }}">
                                </div>
                                <div>
                                    <label class="{{ $label }}">Track # *</label>
                                    <input type="number" name="track_number" value="{{ $album->tracks->count() + 1 }}" required class="{{ $input }}" min="1">
                                </div>
                                <div>
                                    <label class="{{ $label }}">Duration</label>
                                    <input type="text" name="duration" class="{{ $input }}" placeholder="4:32">
                                </div>
                                <div>
                                    <label class="{{ $label }}">Spotify Track ID</label>
                                    <input type="text" name="spotify_track_id" class="{{ $input }}" placeholder="Track ID from Spotify">
                                </div>
                                <div class="col-span-2 sm:col-span-3 flex items-center gap-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="is_featured" value="1" class="accent-ar-red">
                                        <span class="text-sm text-ar-text2">Featured track</span>
                                    </label>
                                    <button type="submit" class="ml-auto px-5 py-2 bg-ar-red text-white text-xs font-semibold tracking-widest uppercase">Add Track</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-4">
        @if($isEdit)
            <div class="bg-ar-dark border border-ar-border p-5">
                <h3 class="text-xs text-ar-text2 uppercase tracking-widest mb-3">Album Preview</h3>
                @if($album->cover_image)
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full aspect-square object-cover mb-3">
                @endif
                @if($album->spotify_embed)
                    <iframe src="{{ $album->spotify_embed }}" width="100%" height="152" frameborder="0"
                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                @endif
            </div>

            <form action="{{ route('admin.music.destroy', $album) }}" method="POST" onsubmit="return confirm('Delete this release and all tracks?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-2 border border-ar-red/30 text-ar-red hover:bg-ar-red hover:text-white text-xs font-semibold tracking-widest uppercase transition-all">
                    Delete Release
                </button>
            </form>
        @endif
    </div>
</div>

@endsection
