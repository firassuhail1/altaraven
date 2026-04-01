<?php

namespace App\Http\Controllers;

use App\Models\Album;

class MusicController extends Controller
{
    public function index()
    {
        $albums = Album::with('tracks')->orderByDesc('release_year')->orderByDesc('id')->get();
        return view('pages.public.music', compact('albums'));
    }

    public function show(string $slug)
    {
        $album = Album::with('tracks')->where('slug', $slug)->firstOrFail();
        return view('pages.public.music-show', compact('album'));
    }
}
