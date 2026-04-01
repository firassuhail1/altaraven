@extends('layouts.admin')
@section('title', $member->exists ? 'Edit: ' . $member->name : 'Add Member')

@section('content')

@php
    $isEdit = $member->exists;
    $action = $isEdit ? route('admin.members.update', $member) : route('admin.members.store');
    $input  = 'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
    $label  = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
@endphp

<div class="mb-6">
    <a href="{{ route('admin.members.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Members</a>
</div>

<div class="max-w-2xl">
    <div class="bg-ar-dark border border-ar-border p-6">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($isEdit) @method('PUT') @endif

            @if($isEdit && $member->photo)
                <div>
                    <p class="{{ $label }}">Current Photo</p>
                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-24 h-24 object-cover bg-ar-gray">
                </div>
            @endif

            <div>
                <label class="{{ $label }}">Photo</label>
                <input type="file" name="photo" accept="image/*" class="{{ $input }} py-2 file:mr-3 file:bg-ar-red file:border-0 file:text-white file:text-xs file:px-3 file:py-1 file:cursor-pointer">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $label }}">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="{{ $input }}">
                    @error('name') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="{{ $label }}">Role *</label>
                    <input type="text" name="role" value="{{ old('role', $member->role) }}" required class="{{ $input }}" placeholder="Vocals, Guitar, Bass, Drums...">
                    @error('role') <p class="text-ar-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="{{ $label }}">Bio</label>
                <textarea name="bio" rows="4" class="{{ $input }} resize-none" placeholder="Short bio...">{{ old('bio', $member->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $label }}">Display Order</label>
                    <input type="number" name="order" value="{{ old('order', $member->order ?? 0) }}" class="{{ $input }}" min="0">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }} class="accent-ar-red">
                        <span class="text-sm text-ar-text2">Active / Visible</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                    {{ $isEdit ? 'Save Changes' : 'Add Member' }}
                </button>
                <a href="{{ route('admin.members.index') }}" class="px-6 py-3 border border-ar-border text-ar-text2 hover:text-ar-white text-sm tracking-widest uppercase transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
