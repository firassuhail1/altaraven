{{-- contact-messages.blade.php --}}
@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')

<div class="bg-ar-dark border border-ar-border overflow-x-auto">
    <table class="admin-table">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Preview</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr class="{{ !$message->is_read ? 'bg-ar-red/5' : '' }}">
                    <td>
                        <p class="text-ar-white text-sm font-medium">{{ $message->name }}</p>
                        <p class="text-ar-text2 text-xs">{{ $message->email }}</p>
                    </td>
                    <td class="text-ar-text2 text-sm">{{ $message->subject ?? '(no subject)' }}</td>
                    <td class="text-ar-text2 text-xs max-w-xs truncate">{{ Str::limit($message->message, 60) }}</td>
                    <td class="text-ar-text2 text-xs whitespace-nowrap">{{ $message->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <span class="{{ $message->is_read ? 'badge-gray' : 'badge-red' }}">
                            {{ $message->is_read ? 'Read' : 'New' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-xs text-ar-text2 hover:text-ar-white transition-colors">View</a>
                            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-ar-text2 hover:text-ar-red transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-ar-text2 py-8">No messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $messages->links() }}</div>

@endsection
