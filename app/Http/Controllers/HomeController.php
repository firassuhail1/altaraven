<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\BandInfo;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $bandInfo      = BandInfo::getInstance();
        // $galleryItems = GalleryItem::where('is_active', true)->orderBy('order')->get();
        $galleryItems = GalleryItem::active()->take(7)->get();
        $latestRelease = Album::with('tracks')->orderByDesc('release_year')->orderByDesc('id')->first();
        $upcomingEvent = Event::upcoming()->first();
        $featuredMerch = Product::active()->featured()->with('images')->orderBy('order')->take(3)->get();

        return view('pages.public.home', compact(
            'bandInfo',
            'galleryItems',
            'latestRelease',
            'upcomingEvent',
            'featuredMerch'
        ));
    }
}
