<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\BandInfo;
use App\Models\ChatRoom;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Member;
use App\Models\Order;
use App\Models\Product;
use App\Models\Track;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// ─── Dashboard ────────────────────────────────────────────────────────────────
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_pending'   => Order::where('status', 'pending')->count(),
            'orders_total'     => Order::count(),
            'revenue'          => Order::whereIn('status', ['paid','processing','shipped','delivered'])->sum('total'),
            'products'         => Product::active()->count(),
            'events_upcoming'  => Event::upcoming()->count(),
            'unread_messages'  => ContactMessage::where('is_read', false)->count(),
            'active_chats'     => ChatRoom::where('status', 'open')->count(),
        ];

        $recentOrders = Order::with('items')->latest()->take(5)->get();
        $recentChats  = ChatRoom::with('latestMessage')->where('status', 'open')
            ->orderByDesc('last_message_at')->take(5)->get();

        return view('pages.admin.dashboard', compact('stats', 'recentOrders', 'recentChats'));
    }
}

// ─── Band Info ────────────────────────────────────────────────────────────────
class BandInfoController extends Controller
{
    public function edit()
    {
        $bandInfo = BandInfo::getInstance();
        return view('pages.admin.band-info', compact('bandInfo'));
    }

    public function update(Request $request)
    {
        $bandInfo = BandInfo::getInstance();
        $data = $request->validate([
            'band_name'    => 'required|string|max:100',
            'tagline'      => 'nullable|string|max:255',
            'history'      => 'nullable|string',
            'description'  => 'nullable|string',
            'founded_year' => 'nullable|string|max:4',
            'genre'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'email'        => 'nullable|email',
            'hero_video'   => 'nullable|url',
            'social_links' => 'nullable|array',
            'hero_image'   => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('hero_image')) {
            if ($bandInfo->hero_image) Storage::disk('public')->delete($bandInfo->hero_image);
            $data['hero_image'] = $request->file('hero_image')->store('band', 'public');
        }

        $bandInfo->update($data);
        return back()->with('success', 'Informasi band berhasil diperbarui!');
    }
}

// ─── Members ──────────────────────────────────────────────────────────────────
class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('order')->get();
        return view('pages.admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('pages.admin.members.form', ['member' => new Member()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|string|max:100',
            'bio'       => 'nullable|string',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
            'photo'     => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create($data);
        return redirect()->route('admin.members.index')->with('success', 'Personel berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        return view('pages.admin.members.form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|string|max:100',
            'bio'       => 'nullable|string',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
            'photo'     => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);
        return redirect()->route('admin.members.index')->with('success', 'Personel berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->photo) Storage::disk('public')->delete($member->photo);
        $member->delete();
        return back()->with('success', 'Personel dihapus.');
    }
}

// ─── Music / Albums ───────────────────────────────────────────────────────────
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
            'title'              => 'required|string|max:200',
            'description'        => 'nullable|string',
            'release_year'       => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'spotify_album_id'   => 'nullable|string|max:50',
            'spotify_embed_url'  => 'nullable|url',
            'type'               => 'required|in:album,ep,single',
            'is_featured'        => 'boolean',
            'order'              => 'integer|min:0',
            'cover_image'        => 'nullable|image|max:5120',
        ]);

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

    // Track CRUD
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

        $album->tracks()->create($data);
        return back()->with('success', 'Track berhasil ditambahkan!');
    }

    public function destroyTrack(Track $track)
    {
        $track->delete();
        return back()->with('success', 'Track dihapus.');
    }

    // Spotify search API passthrough
    public function spotifySearch(Request $request, SpotifyService $spotify)
    {
        $results = $spotify->searchAlbums($request->q);
        return response()->json($results);
    }
}

// ─── Events ───────────────────────────────────────────────────────────────────
class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc('event_date')->paginate(15);
        return view('pages.admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('pages.admin.events.form', ['event' => new Event()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:200',
            'description'  => 'nullable|string',
            'event_date'   => 'required|date',
            'event_time'   => 'nullable|date_format:H:i',
            'venue'        => 'nullable|string|max:200',
            'city'         => 'required|string|max:100',
            'country'      => 'nullable|string|max:100',
            'ticket_url'   => 'nullable|url',
            'ticket_price' => 'nullable|numeric|min:0',
            'status'       => 'required|in:upcoming,past,cancelled',
            'is_featured'  => 'boolean',
            'poster_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('poster_image')) {
            $data['poster_image'] = $request->file('poster_image')->store('events', 'public');
        }

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        return view('pages.admin.events.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:200',
            'description'  => 'nullable|string',
            'event_date'   => 'required|date',
            'event_time'   => 'nullable|date_format:H:i',
            'venue'        => 'nullable|string|max:200',
            'city'         => 'required|string|max:100',
            'country'      => 'nullable|string|max:100',
            'ticket_url'   => 'nullable|url',
            'ticket_price' => 'nullable|numeric|min:0',
            'status'       => 'required|in:upcoming,past,cancelled',
            'is_featured'  => 'boolean',
            'poster_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('poster_image')) {
            if ($event->poster_image) Storage::disk('public')->delete($event->poster_image);
            $data['poster_image'] = $request->file('poster_image')->store('events', 'public');
        }

        $event->update($data);
        return back()->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->poster_image) Storage::disk('public')->delete($event->poster_image);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event dihapus.');
    }
}
