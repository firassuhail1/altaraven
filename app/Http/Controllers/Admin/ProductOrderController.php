<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariantStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// ─── Products ─────────────────────────────────────────────────────────────────
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

    // ─── Variants ──────────────────────────────────────────────────────────────
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

    // ─── Stock Management ──────────────────────────────────────────────────────
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

// ─── Orders ───────────────────────────────────────────────────────────────────
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                    ->orWhere('customer_name', 'like', "%{$request->search}%")
                    ->orWhere('customer_email', 'like', "%{$request->search}%");
            });
        }

        $orders   = $query->paginate(20)->withQueryString();
        $statuses = Order::STATUS_LABELS;

        return view('pages.admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'items.variant', 'chatRoom.messages']);
        return view('pages.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:' . implode(',', array_keys(Order::STATUS_LABELS)),
            'tracking_number' => 'nullable|string|max:100',
            'admin_notes'     => 'nullable|string|max:500',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'paid' && !$order->paid_at) {
            $updateData['paid_at'] = now();
        }
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $updateData['shipped_at'] = now();
            $updateData['tracking_number'] = $request->tracking_number;
        }
        if ($request->admin_notes) {
            $updateData['admin_notes'] = $request->admin_notes;
        }

        $order->update($updateData);

        return back()->with('success', "Status order diperbarui ke: {$order->fresh()->status_label}");
    }
}

// ─── Contact Messages ─────────────────────────────────────────────────────────
class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('pages.admin.contact-messages', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();
        return view('pages.admin.contact-message-show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Pesan dihapus.');
    }
}

// ─── Chat Rooms ───────────────────────────────────────────────────────────────
class AdminChatController extends Controller
{
    public function index()
    {
        $rooms = ChatRoom::with(['latestMessage', 'order'])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('pages.admin.chats.index', compact('rooms'));
    }

    public function show(ChatRoom $chatRoom)
    {
        $chatRoom->load(['messages', 'order']);
        $chatRoom->messages()->where('sender_type', 'customer')->update(['is_read' => true]);
        return view('pages.admin.chats.show', compact('chatRoom'));
    }

    public function close(ChatRoom $chatRoom)
    {
        $chatRoom->update(['status' => 'closed']);
        return back()->with('success', 'Chat room ditutup.');
    }
}
