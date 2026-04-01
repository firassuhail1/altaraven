<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariantStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withCount('variants')->with('images')->orderBy('order')->paginate(20);
        return view('pages.admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.admin.products.form', ['product' => new Product()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'base_price'  => 'required|numeric|min:0',
            'category'    => 'required|string|max:50',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'order'       => 'integer|min:0',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:5120',
        ]);

        $data['is_active']   = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store("products/{$product->id}", 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $i === 0,
                    'order'      => $i,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Produk berhasil dibuat! Tambahkan varian di bawah.');
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'variants.stock']);
        return view('pages.admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'base_price'  => 'required|numeric|min:0',
            'category'    => 'required|string|max:50',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'order'       => 'integer|min:0',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:5120',
        ]);

        $data['is_active']   = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');

        $product->update($data);

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store("products/{$product->id}", 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $existingCount === 0 && $i === 0,
                    'order'      => $existingCount + $i,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Gambar dihapus.');
    }

    public function setPrimaryImage(ProductImage $image)
    {
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        return back()->with('success', 'Gambar utama diperbarui.');
    }

    public function storeVariant(Request $request, Product $product)
    {
        $data = $request->validate([
            'size'           => 'nullable|string|max:20',
            'type'           => 'nullable|string|max:50',
            'color'          => 'nullable|string|max:50',
            'color_hex'      => 'nullable|string|max:7',
            'custom_option'  => 'nullable|string|max:100',
            'price_modifier' => 'nullable|numeric',
            'sku'            => 'nullable|string|max:100|unique:product_variants,sku',
            'initial_stock'  => 'integer|min:0',
        ]);

        if (is_null($data['price_modifier'])) {
            unset($data['price_modifier']); // biarkan DB default (0) yang mengisi
        }

        $variant = $product->variants()->create($data);

        VariantStock::create([
            'product_variant_id' => $variant->id,
            'quantity'           => $data['initial_stock'] ?? 0,
        ]);

        return back()->with('success', 'Varian berhasil ditambahkan!');
    }

    public function destroyVariant(ProductVariant $variant)
    {
        $variant->delete();
        return back()->with('success', 'Varian dihapus.');
    }

    public function adjustStock(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'change' => 'required|integer',
            'reason' => 'nullable|string|max:200',
        ]);

        $stock = $variant->stock ?? VariantStock::create([
            'product_variant_id' => $variant->id,
            'quantity'           => 0,
        ]);

        $stock->adjust($request->change, $request->reason ?? 'manual', Auth::id());

        return back()->with('success', 'Stok berhasil diperbarui!');
    }
}
