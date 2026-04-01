{{-- pages/admin/orders/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Orders')

@section('content')

    {{-- Filters --}}
    <div class="flex flex-wrap gap-2 mb-5">
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                class="bg-ar-gray border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2 text-sm focus:border-ar-red focus:outline-none w-48"
                placeholder="Search order / name...">
            <select name="status"
                class="bg-ar-gray border border-ar-border text-ar-white px-3 py-2 text-sm focus:border-ar-red focus:outline-none">
                <option value="">All Status</option>
                @foreach ($statuses as $val => $lbl)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                        {{ $lbl }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-ar-red text-white text-xs font-semibold tracking-widest uppercase">Filter</button>
            <a href="{{ route('admin.orders.index') }}"
                class="px-4 py-2 border border-ar-border text-ar-text2 hover:text-ar-white text-xs uppercase">Reset</a>
        </form>
    </div>

    <div class="bg-ar-dark border border-ar-border overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="font-mono text-xs text-ar-white">{{ $order->order_number }}</td>
                        <td>
                            <p class="text-ar-white text-sm font-medium">{{ $order->customer_name }}</p>
                            <p class="text-ar-text2 text-xs">{{ $order->customer_email }}</p>
                        </td>
                        <td class="text-ar-text2 text-xs">{{ $order->items->count() }} item(s)</td>
                        <td class="text-ar-red font-semibold">{{ $order->formatted_total }}</td>
                        <td>
                            <span
                                class="text-xs px-2 py-0.5 bg-{{ $order->status_color }}-900/40 text-{{ $order->status_color }}-400 border border-{{ $order->status_color }}-800/50">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="text-ar-text2 text-xs whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="text-xs text-ar-text2 hover:text-ar-white transition-colors">View →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-ar-text2 py-8">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>

@endsection
