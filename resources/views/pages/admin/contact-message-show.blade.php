@extends('layouts.admin')
@section('title', 'Message from ' . $contactMessage->name)

@section('content')

    <div class="mb-5">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Messages</a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-ar-dark border border-ar-border p-6">
            <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-ar-border text-sm">
                <div>
                    <p class="text-xs text-ar-text2 tracking-widest uppercase mb-1">From</p>
                    <p class="text-ar-white font-medium">{{ $contactMessage->name }}</p>
                    <a href="mailto:{{ $contactMessage->email }}"
                        class="text-ar-text2 hover:text-ar-red text-xs transition-colors">
                        {{ $contactMessage->email }}
                    </a>
                </div>
                <div>
                    <p class="text-xs text-ar-text2 tracking-widest uppercase mb-1">Received</p>
                    <p class="text-ar-white">{{ $contactMessage->created_at->format('d M Y, H:i') }}</p>
                </div>
                @if ($contactMessage->subject)
                    <div class="col-span-2">
                        <p class="text-xs text-ar-text2 tracking-widest uppercase mb-1">Subject</p>
                        <p class="text-ar-white">{{ $contactMessage->subject }}</p>
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs text-ar-text2 tracking-widest uppercase mb-3">Message</p>
                <div class="text-ar-text leading-relaxed whitespace-pre-wrap">{{ $contactMessage->message }}</div>
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t border-ar-border">
                {{-- <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" target="_blank" --}}
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $contactMessage->email }}&su=Re: {{ $contactMessage->subject }}"
                    target="_blank"
                    class="px-5 py-2.5 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
                    Reply via Email
                </a>
                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST"
                    onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 border border-ar-border text-ar-text2 hover:border-ar-red hover:text-ar-red text-xs font-semibold tracking-widest uppercase transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
