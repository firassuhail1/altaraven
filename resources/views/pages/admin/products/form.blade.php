@extends('layouts.admin')
@section('title', $product->exists ? 'Edit: ' . $product->name : 'New Product')

@section('content')

    @php
        $isEdit = $product->exists;
        $action = $isEdit ? route('admin.products.update', $product) : route('admin.products.store');
        $input =
            'w-full bg-[#111] border border-ar-border text-ar-white placeholder-ar-text2 px-3 py-2.5 text-sm focus:border-ar-red focus:outline-none transition-colors';
        $label = 'block text-xs tracking-widest uppercase text-ar-text2 mb-1.5';
    @endphp

    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="text-xs text-ar-text2 hover:text-ar-white">← Products</a>
        <h1 class="text-lg font-semibold text-ar-white">{{ $isEdit ? 'Edit: ' . $product->name : 'New Product' }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main form --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-ar-dark border border-ar-border p-6">

                {{-- ===================== --}}
                {{-- FORM UTAMA PRODUCT   --}}
                {{-- ===================== --}}
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="{{ $label }}">Product Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Description</label>
                        <textarea name="description" rows="4" class="{{ $input }} resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="{{ $label }}">Base Price (Rp) *</label>
                            <input type="number" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                                required class="{{ $input }}" min="0">
                        </div>
                        <div>
                            <label class="{{ $label }}">Category *</label>
                            <select name="category" class="{{ $input }}">
                                @foreach (['apparel', 'accessories', 'vinyl', 'digital', 'other'] as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="{{ $label }}">Sort Order</label>
                            <input type="number" name="order" value="{{ old('order', $product->order ?? 0) }}"
                                class="{{ $input }}" min="0">
                        </div>
                        <div class="flex items-end gap-3 pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                                    class="accent-ar-red">
                                <span class="text-sm text-ar-text2">Active</span>
                            </label>
                        </div>
                        <div class="flex items-end gap-3 pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
                                    class="accent-ar-red">
                                <span class="text-sm text-ar-text2">Featured</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="{{ $label }}">Product Images</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="{{ $input }} py-2 file:mr-3 file:bg-ar-red file:border-0 file:text-white file:text-xs file:px-3 file:py-1 file:cursor-pointer">
                        <p class="text-xs text-ar-text2 mt-1">First image will be primary. Max 5MB each.</p>
                    </div>

                    {{-- Existing images — tombol pakai form="..." agar tidak nested --}}
                    @if ($isEdit && $product->images->count())
                        <div>
                            <p class="{{ $label }}">Current Images</p>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach ($product->images as $img)
                                    <div class="relative group">
                                        <img src="{{ $img->url }}" alt=""
                                            class="aspect-square object-cover w-full {{ $img->is_primary ? 'ring-2 ring-ar-red' : '' }}">
                                        <div
                                            class="absolute inset-0 bg-ar-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-1 p-1">
                                            @unless ($img->is_primary)
                                                <button type="submit" form="form-primary-{{ $img->id }}"
                                                    class="w-full text-[10px] bg-ar-red/80 text-white py-0.5">
                                                    Set Primary
                                                </button>
                                            @endunless
                                            <button type="submit" form="form-delete-img-{{ $img->id }}"
                                                class="w-full text-[10px] bg-ar-black/80 text-ar-text2 hover:text-ar-red py-0.5">
                                                Delete
                                            </button>
                                        </div>
                                        @if ($img->is_primary)
                                            <span
                                                class="absolute top-1 left-1 text-[9px] bg-ar-red text-white px-1">PRIMARY</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <button type="submit"
                        class="px-6 py-3 bg-ar-red hover:bg-ar-red2 text-white text-sm font-semibold tracking-widest uppercase transition-colors">
                        {{ $isEdit ? 'Update Product' : 'Create Product' }}
                    </button>

                </form>
                {{-- END FORM UTAMA --}}

                {{-- ============================================================ --}}
                {{-- FORM GAMBAR — di luar form utama, dihubungkan via form="id"  --}}
                {{-- ============================================================ --}}
                @if ($isEdit && $product->images->count())
                    @foreach ($product->images as $img)
                        @unless ($img->is_primary)
                            <form id="form-primary-{{ $img->id }}"
                                action="{{ route('admin.products.images.primary', $img) }}" method="POST"
                                style="display:none">
                                @csrf
                            </form>
                        @endunless
                        <form id="form-delete-img-{{ $img->id }}"
                            action="{{ route('admin.products.images.destroy', $img) }}" method="POST"
                            onsubmit="return confirm('Delete this image?')" style="display:none">
                            @csrf @method('DELETE')
                        </form>
                    @endforeach
                @endif

            </div>

            {{-- Variants (only when editing) --}}
            @if ($isEdit)
                <div class="bg-ar-dark border border-ar-border p-6">
                    <h2 class="font-semibold text-ar-white mb-5">Variants & Stock</h2>

                    {{-- Existing variants --}}
                    @if ($product->variants->count())
                        <div class="mb-6 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-ar-border text-xs text-ar-text2 tracking-widest uppercase">
                                        <th class="text-left py-2 pr-3">Size</th>
                                        <th class="text-left py-2 pr-3">Type</th>
                                        <th class="text-left py-2 pr-3">Color</th>
                                        <th class="text-left py-2 pr-3">Price</th>
                                        <th class="text-left py-2 pr-3">Stock</th>
                                        <th class="text-left py-2 pr-3">Adjust</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-ar-border">
                                    @foreach ($product->variants as $variant)
                                        <tr>
                                            <td class="py-2.5 pr-3 text-ar-white">{{ $variant->size ?? '—' }}</td>
                                            <td class="py-2.5 pr-3 text-ar-text2">{{ $variant->type ?? '—' }}</td>
                                            <td class="py-2.5 pr-3">
                                                @if ($variant->color)
                                                    <div class="flex items-center gap-1.5">
                                                        @if ($variant->color_hex)
                                                            <span class="w-3 h-3 rounded-full border border-ar-border"
                                                                style="background:{{ $variant->color_hex }}"></span>
                                                        @endif
                                                        <span class="text-ar-text2">{{ $variant->color }}</span>
                                                    </div>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="py-2.5 pr-3 text-ar-white">Rp
                                                {{ number_format($variant->final_price, 0, ',', '.') }}</td>
                                            <td class="py-2.5 pr-3">
                                                <span
                                                    class="{{ $variant->isInStock() ? 'text-green-400' : 'text-ar-red' }} font-medium">
                                                    {{ $variant->stock_quantity }}
                                                </span>
                                                @if ($variant->isLowStock())
                                                    <span class="ml-1 text-yellow-500 text-xs">Low</span>
                                                @endif
                                            </td>
                                            <td class="py-2.5 pr-3">
                                                {{-- Form stock adjust berdiri sendiri, tidak di dalam form lain --}}
                                                <form action="{{ route('admin.products.variants.stock', $variant) }}"
                                                    method="POST" class="flex items-center gap-1">
                                                    @csrf
                                                    <input type="number" name="change"
                                                        class="w-16 bg-ar-gray border border-ar-border text-ar-white text-xs px-2 py-1 text-center focus:border-ar-red focus:outline-none"
                                                        placeholder="±qty">
                                                    <input type="text" name="reason"
                                                        class="w-24 bg-ar-gray border border-ar-border text-ar-white text-xs px-2 py-1 focus:border-ar-red focus:outline-none"
                                                        placeholder="reason">
                                                    <button type="submit"
                                                        class="text-xs bg-ar-red/20 border border-ar-red/30 text-ar-red hover:bg-ar-red hover:text-white px-2 py-1 transition-colors">✓</button>
                                                </form>
                                            </td>
                                            <td class="py-2.5">
                                                {{-- Form delete variant berdiri sendiri --}}
                                                <form action="{{ route('admin.products.variants.destroy', $variant) }}"
                                                    method="POST" onsubmit="return confirm('Delete this variant?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-ar-text2 hover:text-ar-red transition-colors text-xs">✕</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Add variant form --}}
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="text-xs px-4 py-2 border border-ar-border text-ar-text2 hover:border-ar-red hover:text-ar-white transition-colors">
                            + Add Variant
                        </button>
                        <div x-show="open" x-transition class="mt-4 border border-ar-border p-4 bg-ar-gray/20">
                            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                    <div>
                                        <label class="{{ $label }}">Size</label>
                                        <select name="size" class="{{ $input }}">
                                            <option value="">—</option>
                                            @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'] as $s)
                                                <option value="{{ $s }}">{{ $s }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">Type</label>
                                        <select name="type" class="{{ $input }}">
                                            <option value="">—</option>
                                            @foreach (['Short Sleeve', 'Long Sleeve', 'Hoodie', 'Tank Top', 'Cap', 'Tote Bag'] as $t)
                                                <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">Color</label>
                                        <input type="text" name="color" class="{{ $input }}"
                                            placeholder="Black">
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">Color Hex</label>
                                        <input type="color" name="color_hex"
                                            class="{{ $input }} h-10 cursor-pointer p-1" value="#000000">
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">Price ±</label>
                                        <input type="number" name="price_modifier" class="{{ $input }}"
                                            placeholder="0" step="1000">
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">SKU</label>
                                        <input type="text" name="sku" class="{{ $input }}"
                                            placeholder="AR-TS-BLK-M">
                                    </div>
                                    <div>
                                        <label class="{{ $label }}">Initial Stock</label>
                                        <input type="number" name="initial_stock" class="{{ $input }}"
                                            placeholder="0" min="0">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit"
                                            class="w-full py-2.5 bg-ar-red hover:bg-ar-red2 text-white text-xs font-semibold tracking-widest uppercase transition-colors">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar info --}}
        <div class="space-y-4">
            @if ($isEdit)
                <div class="bg-ar-dark border border-ar-border p-5">
                    <h3 class="text-xs text-ar-text2 uppercase tracking-widest mb-3">Quick Info</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-ar-text2">ID</span><span
                                class="text-ar-white">#{{ $product->id }}</span></div>
                        <div class="flex justify-between"><span class="text-ar-text2">Variants</span><span
                                class="text-ar-white">{{ $product->variants->count() }}</span></div>
                        <div class="flex justify-between"><span class="text-ar-text2">Status</span>
                            <span
                                class="{{ $product->is_active ? 'text-green-400' : 'text-ar-red' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
                        </div>
                        <div class="flex justify-between"><span class="text-ar-text2">Featured</span>
                            <span
                                class="{{ $product->is_featured ? 'text-yellow-400' : 'text-ar-text2' }}">{{ $product->is_featured ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                    onsubmit="return confirm('Delete this product and all its variants?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full py-2 border border-ar-red/30 text-ar-red hover:bg-ar-red hover:text-white text-xs font-semibold tracking-widest uppercase transition-all">
                        Delete Product
                    </button>
                </form>
            @endif
        </div>
    </div>

@endsection
