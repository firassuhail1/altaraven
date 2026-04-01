<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('merch.index')->with('error', 'Keranjang kamu kosong.');
        }

        $items = $this->cart->get();
        $total = $this->cart->total();
        return view('pages.public.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('merch.index')->with('error', 'Keranjang kamu kosong.');
        }

        $data = $request->validate([
            'customer_name'        => 'required|string|max:255',
            'customer_email'       => 'required|email',
            'customer_phone'       => 'nullable|string|max:20',
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string|max:100',
            'shipping_province'    => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:10',
            'notes'                => 'nullable|string|max:500',
        ]);

        $items    = $this->cart->get();
        $subtotal = $this->cart->total();

        $order = Order::create(array_merge($data, [
            'subtotal'      => $subtotal,
            'shipping_cost' => 0,
            'total'         => $subtotal,
            'status'        => 'pending',
        ]));

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $item['product_id'],
                'product_variant_id' => $item['variant_id'],
                'product_name'       => $item['product_name'],
                'variant_info'       => $item['variant_info'],
                'price'              => $item['price'],
                'quantity'           => $item['quantity'],
                'subtotal'           => $item['price'] * $item['quantity'],
            ]);
        }

        $chatRoom = ChatRoom::create([
            'order_id'       => $order->id,
            'customer_name'  => $order->customer_name,
            'customer_email' => $order->customer_email,
            'subject'        => "Order #{$order->order_number}",
        ]);

        $this->cart->clear();

        return redirect()->route('order.success', ['room' => $chatRoom->room_key]);
    }
}
