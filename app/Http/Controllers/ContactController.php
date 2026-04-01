<?php

namespace App\Http\Controllers;

use App\Models\BandInfo;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $bandInfo = BandInfo::getInstance();
        return view('pages.public.contact', compact('bandInfo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Pesan kamu sudah terkirim! Kami akan segera merespons.');
    }
}
