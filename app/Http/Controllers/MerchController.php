<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MerchController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('images');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $products   = $query->orderBy('order')->paginate(12);
        $categories = Product::active()->select('category')->distinct()->pluck('category');

        return view('pages.public.merch', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->with(['images', 'variants.stock'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.public.merch-show', compact('product'));
    }
}
