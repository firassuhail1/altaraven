{{-- events/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Events')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
        + Add Event
    </a>
</div>

<div class="bg-ar-dark border border-ar-border overflow-x-auto">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>City</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td class="text-ar-text2 whitespace-nowrap">{{ $event->event_date->format('d M Y') }}</td>
                    <td class="font-medium text-ar-white">{{ $event->name }}</td>
                    <td class="text-ar-text2">{{ $event->city }}</td>
                    <td>
                        <span class="text-xs px-2 py-0.5
                            {{ $event->status === 'upcoming' ? 'bg-green-900/40 text-green-400 border border-green-800/50' :
                               ($event->status === 'cancelled' ? 'badge-red' : 'badge-gray') }}">
                            {{ strtoupper($event->status) }}
                        </span>
                    </td>
                    <td>{{ $event->is_featured ? '★' : '—' }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-xs text-ar-text2 hover:text-ar-white transition-colors">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-ar-text2 hover:text-ar-red transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-ar-text2 py-8">No events yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $events->links() }}

@endsection
