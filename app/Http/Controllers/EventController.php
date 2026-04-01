<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'upcoming');

        $query = Event::query();
        if ($filter === 'past') {
            $query->past();
        } else {
            $query->upcoming();
        }

        $events = $query->paginate(9);
        return view('pages.public.events', compact('events', 'filter'));
    }
}
