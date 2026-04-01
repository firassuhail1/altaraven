@extends('layouts.admin')
@section('title', $event->exists ? 'Edit: ' . $event->name : 'Add Event')

@section('content')

@php
    $isEdit = $event->exists;
    $action = $isEdit ? route('admin.events.update', $event) : route('admin.events.store');
    $input  = 'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
    $label  = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
@endphp

<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Events</a>
</div>

<div class="max-w-2xl">
    <div class="bg-ar-dark border border-ar-border p-6">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div>
                <label class="{{ $label }}">Event Name *</label>
                <input type="text" name="name" value="{{ old('name', $event->name) }}" required class="{{ $input }}">
            </div>

            <div>
                <label class="{{ $label }}">Description</label>
                <textarea name="description" rows="3" class="{{ $input }} resize-none">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $label }}">Date *</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required class="{{ $input }}">
                </div>
                <div>
                    <label class="{{ $label }}">Time</label>
                    <input type="time" name="event_time" value="{{ old('event_time', $event->event_time) }}" class="{{ $input }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $label }}">Venue</label>
                    <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" class="{{ $input }}" placeholder="Venue / Club name">
                </div>
                <div>
                    <label class="{{ $label }}">City *</label>
                    <input type="text" name="city" value="{{ old('city', $event->city) }}" required class="{{ $input }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $label }}">Country</label>
                    <input type="text" name="country" value="{{ old('country', $event->country ?? 'Indonesia') }}" class="{{ $input }}">
                </div>
                <div>
                    <label class="{{ $label }}">Ticket Price (Rp)</label>
                    <input type="number" name="ticket_price" value="{{ old('ticket_price', $event->ticket_price) }}" class="{{ $input }}" min="0" placeholder="0 = free">
                </div>
            </div>

            <div>
                <label class="{{ $label }}">Ticket URL</label>
                <input type="url" name="ticket_url" value="{{ old('ticket_url', $event->ticket_url) }}" class="{{ $input }}" placeholder="https://...">
            </div>

            <div>
                <label class="{{ $label }}">Status *</label>
                <select name="status" class="{{ $input }}">
                    @foreach(['upcoming' => 'Upcoming', 'past' => 'Past', 'cancelled' => 'Cancelled'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('status', $event->status ?? 'upcoming') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="{{ $label }}">Poster Image</label>
                @if($isEdit && $event->poster_image)
                    <img src="{{ $event->poster_url }}" alt="{{ $event->name }}" class="w-32 h-auto mb-3">
                @endif
                <input type="file" name="poster_image" accept="image/*" class="{{ $input }} py-2 file:mr-3 file:bg-ar-red file:border-0 file:text-white file:text-xs file:px-3 file:py-1 file:cursor-pointer">
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }} class="accent-ar-red">
                <span class="text-sm text-ar-text2">Featured on homepage</span>
            </label>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                    {{ $isEdit ? 'Save Event' : 'Add Event' }}
                </button>
                <a href="{{ route('admin.events.index') }}" class="px-6 py-3 border border-ar-border text-ar-text2 hover:text-ar-white text-sm tracking-widest uppercase transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
