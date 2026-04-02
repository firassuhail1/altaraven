<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        $items = $this->cart->get();
        $total = $this->cart->total();
        return view('pages.public.cart', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity'   => 'integer|min:1|max:99',
        ]);

        $this->cart->add(
            $request->product_id,
            $request->variant_id,
            $request->quantity ?? 1
        );

        return back()->with('success', 'Item ditambahkan ke keranjang!');
    }

    // public function update(Request $request, string $key)
    // {
    //     $request->validate(['quantity' => 'required|integer|min:0|max:99']);
    //     $this->cart->update($key, $request->quantity);
    //     return back()->with('success', 'Keranjang diperbarui.');
    // }

    public function update(Request $request, string $key)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:99']);
        $this->cart->update($key, $request->quantity);

        if ($request->expectsJson()) {
            $items = $this->cart->get();
            $total = $this->cart->total();

            // Hitung subtotal item ini
            $subtotal = isset($items[$key])
                ? $items[$key]['price'] * $items[$key]['quantity']
                : 0;

            return response()->json([
                'success' => true,
                'total' => number_format($total, 0, ',', '.'),
                'subtotal' => number_format($subtotal, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(string $key)
    {
        $this->cart->remove($key);
        return back()->with('success', 'Item dihapus.');
    }
}
