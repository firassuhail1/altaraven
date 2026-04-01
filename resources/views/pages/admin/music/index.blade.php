@extends('layouts.admin')
@section('title', 'Music')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div></div>
        <a href="{{ route('admin.music.create') }}"
            class="px-4 py-2 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
            + Add Album / Single
        </a>
    </div>

    <div class="bg-ar-dark border border-ar-border overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Year</th>
                    <th>Tracks</th>
                    <th>Spotify</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($albums as $album)
                    <tr>
                        <td>
                            <img src="{{ $album->cover_url }}" alt="{{ $album->title }}"
                                class="w-10 h-10 object-cover bg-ar-gray">
                        </td>
                        <td class="font-medium text-ar-white">{{ $album->title }}</td>
                        <td>
                            <span class="badge-gray">{{ strtoupper($album->type) }}</span>
                        </td>
                        <td class="text-ar-text2">{{ $album->release_year }}</td>
                        <td class="text-ar-text2">{{ $album->tracks_count }}</td>
                        <td>
                            @if ($album->spotify_album_id || $album->spotify_embed_url)
                                <span class="text-green-400 text-xs">✓ Linked</span>
                            @else
                                <span class="text-ar-text2 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            @if ($album->is_featured)
                                <span class="badge-yellow">Featured</span>
                            @else
                                <span class="text-ar-text2 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.music.edit', $album) }}"
                                    class="text-xs text-ar-text2 hover:text-ar-white transition-colors">Edit</a>
                                <form action="{{ route('admin.music.destroy', $album) }}" method="POST"
                                    onsubmit="return confirm('Delete {{ $album->title }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-ar-text2 hover:text-ar-red transition-colors">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-ar-text2 py-8">No releases yet. <a
                                href="{{ route('admin.music.create') }}" class="text-ar-red">Add one</a>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
