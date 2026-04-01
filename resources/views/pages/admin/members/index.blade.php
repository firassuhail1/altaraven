@extends('layouts.admin')
@section('title', 'Members')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div></div>
        <a href="{{ route('admin.members.create') }}"
            class="px-4 py-2 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
            + Add Member
        </a>
    </div>

    <div class="bg-ar-dark border border-ar-border overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td class="text-ar-text2">{{ $member->order }}</td>
                        <td>
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                class="w-10 h-10 object-cover bg-ar-gray">
                        </td>
                        <td class="font-medium text-ar-white">{{ $member->name }}</td>
                        <td class="text-ar-text2">{{ $member->role }}</td>
                        <td>
                            <span class="{{ $member->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.members.edit', $member) }}"
                                    class="text-xs text-ar-text2 hover:text-ar-white transition-colors">Edit</a>
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                                    onsubmit="return confirm('Delete {{ $member->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-ar-text2 hover:text-ar-red transition-colors">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-ar-text2 py-8">No members yet. <a
                                href="{{ route('admin.members.create') }}" class="text-ar-red">Add one</a>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
