<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Track;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('tracks')->orderByDesc('release_year')->get();
        return view('pages.admin.music.index', compact('albums'));
    }

    public function create()
    {
        return view('pages.admin.music.form', ['album' => new Album()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:200',
            'description'       => 'nullable|string',
            'release_year'      => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'spotify_album_id'  => 'nullable|string|max:50',
            'spotify_embed_url' => 'nullable|url',
            'type'              => 'required|in:album,ep,single',
            'is_featured'       => 'boolean',
            'order'             => 'integer|min:0',
            'cover_image'       => 'nullable|image|max:5120',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('music/covers', 'public');
        }

        $album = Album::create($data);

        return redirect()->route('admin.music.edit', $album)->with('success', 'Album berhasil ditambahkan!');
    }

    public function edit(Album $album)
    {
        $album->load('tracks');
        return view('pages.admin.music.form', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:200',
            'description'       => 'nullable|string',
            'release_year'      => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'spotify_album_id'  => 'nullable|string|max:50',
            'spotify_embed_url' => 'nullable|url',
            'type'              => 'required|in:album,ep,single',
            'is_featured'       => 'boolean',
            'order'             => 'integer|min:0',
            'cover_image'       => 'nullable|image|max:5120',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('music/covers', 'public');
        }

        $album->update($data);

        return back()->with('success', 'Album berhasil diperbarui!');
    }

    public function destroy(Album $album)
    {
        if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
        $album->delete();
        return redirect()->route('admin.music.index')->with('success', 'Album dihapus.');
    }

    public function storeTrack(Request $request, Album $album)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:200',
            'duration'          => 'nullable|string|max:10',
            'track_number'      => 'required|integer|min:1',
            'spotify_track_id'  => 'nullable|string|max:50',
            'spotify_embed_url' => 'nullable|url',
            'is_featured'       => 'boolean',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $album->tracks()->create($data);

        return back()->with('success', 'Track berhasil ditambahkan!');
    }

    public function destroyTrack(Track $track)
    {
        $track->delete();
        return back()->with('success', 'Track dihapus.');
    }

    public function spotifySearch(Request $request, SpotifyService $spotify)
    {
        try {
            $results = $spotify->searchAlbums($request->get('q', ''));
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
