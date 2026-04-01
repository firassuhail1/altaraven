@extends('layouts.admin')
@section('title', 'Products')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
        + Add Product
    </a>
</div>

<div class="bg-ar-dark border border-ar-border overflow-x-auto">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Variants</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover bg-ar-gray">
                    </td>
                    <td class="font-medium text-ar-white">{{ $product->name }}</td>
                    <td class="text-ar-text2 text-xs uppercase">{{ $product->category }}</td>
                    <td class="text-ar-red font-semibold">{{ $product->formatted_price }}</td>
                    <td class="text-ar-text2">{{ $product->variants_count }}</td>
                    <td>
                        <span class="{{ $product->is_active ? 'badge-green' : 'badge-gray' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        @if($product->is_featured)
                            <span class="badge-yellow">★ Featured</span>
                        @else
                            <span class="text-ar-text2 text-xs">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-ar-text2 hover:text-ar-white transition-colors">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete {{ $product->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-ar-text2 hover:text-ar-red transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-ar-text2 py-8">No products yet. <a href="{{ route('admin.products.create') }}" class="text-ar-red">Create one</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>

@endsection
