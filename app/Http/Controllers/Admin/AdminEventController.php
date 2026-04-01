<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $data['is_featured'] = $request->boolean('is_featured');

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
        // dd($request->all());
        $data = $request->validate([
            'name'         => 'required|string|max:200',
            'description'  => 'nullable|string',
            'event_date'   => 'required|date',
            'event_time' => 'nullable|date_format:H:i,H:i:s',
            'venue'        => 'nullable|string|max:200',
            'city'         => 'required|string|max:100',
            'country'      => 'nullable|string|max:100',
            'ticket_url'   => 'nullable|url',
            'ticket_price' => 'nullable|numeric|min:0',
            'status'       => 'required|in:upcoming,past,cancelled',
            'is_featured'  => 'boolean',
            'poster_image' => 'nullable|image|max:5120',
        ]);

        // dd('ee');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('poster_image')) {
            if ($event->poster_image) Storage::disk('public')->delete($event->poster_image);
            $data['poster_image'] = $request->file('poster_image')->store('events', 'public');
        }

        // dd($data); // apakah 'name' ada dan isinya benar?

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
