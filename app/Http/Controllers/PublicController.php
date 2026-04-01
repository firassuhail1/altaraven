<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\BandInfo;
use App\Models\Event;
use App\Models\Member;
use App\Models\Product;
use App\Models\ContactMessage;
use App\Services\CartService;
use Illuminate\Http\Request;

// ─── About ────────────────────────────────────────────────────────────────────
class AboutController extends Controller
{
    public function index()
    {
        $bandInfo = BandInfo::getInstance();
        $members  = Member::active()->get();
        return view('pages.public.about', compact('bandInfo', 'members'));
    }
}

// ─── Music ────────────────────────────────────────────────────────────────────
class MusicController extends Controller
{
    public function index()
    {
        $albums = Album::with('tracks')->orderByDesc('release_year')->orderByDesc('id')->get();
        return view('pages.public.music', compact('albums'));
    }

    public function show(string $slug)
    {
        $album = Album::with('tracks')->where('slug', $slug)->firstOrFail();
        return view('pages.public.music-show', compact('album'));
    }
}

// ─── Events ───────────────────────────────────────────────────────────────────
class EventController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'upcoming');

        $query = Event::query();
        if ($filter === 'past') {
            $query->past();
        } else {
            $query->upcoming();
        }

        $events = $query->paginate(9);
        return view('pages.public.events', compact('events', 'filter'));
    }
}

// ─── Merch ────────────────────────────────────────────────────────────────────
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

// ─── Cart ─────────────────────────────────────────────────────────────────────
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

    public function update(Request $request, string $key)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:99']);
        $this->cart->update($key, $request->quantity);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(string $key)
    {
        $this->cart->remove($key);
        return back()->with('success', 'Item dihapus.');
    }
}

// ─── Checkout ─────────────────────────────────────────────────────────────────
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

        $order = \App\Models\Order::create(array_merge($data, [
            'subtotal'        => $subtotal,
            'shipping_cost'   => 0,
            'total'           => $subtotal,
            'status'          => 'pending',
        ]));

        foreach ($items as $item) {
            \App\Models\OrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $item['product_id'],
                'product_variant_id'=> $item['variant_id'],
                'product_name'      => $item['product_name'],
                'variant_info'      => $item['variant_info'],
                'price'             => $item['price'],
                'quantity'          => $item['quantity'],
                'subtotal'          => $item['price'] * $item['quantity'],
            ]);
        }

        // Auto-create chat room for order
        $chatRoom = \App\Models\ChatRoom::create([
            'order_id'       => $order->id,
            'customer_name'  => $order->customer_name,
            'customer_email' => $order->customer_email,
            'subject'        => "Order #{$order->order_number}",
        ]);

        $this->cart->clear();

        return redirect()->route('order.success', ['room' => $chatRoom->room_key])
            ->with('order', $order);
    }
}

// ─── Contact ──────────────────────────────────────────────────────────────────
class ContactController extends Controller
{
    public function index()
    {
        $bandInfo = BandInfo::getInstance();
        return view('pages.public.contact', compact('bandInfo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Pesan kamu sudah terkirim! Kami akan segera merespons.');
    }
}

// ─── Order success + chat ──────────────────────────────────────────────────────
class OrderController extends Controller
{
    public function success(Request $request)
    {
        $room = \App\Models\ChatRoom::where('room_key', $request->room)->firstOrFail();
        return view('pages.public.order-success', compact('room'));
    }
}
