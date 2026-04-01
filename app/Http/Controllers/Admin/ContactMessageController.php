<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('pages.admin.contact-messages', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();
        return view('pages.admin.contact-message-show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Pesan dihapus.');
    }
}
