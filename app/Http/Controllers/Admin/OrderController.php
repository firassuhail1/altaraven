<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

        if ($request->status === 'paid' && ! $order->paid_at) {
            $updateData['paid_at'] = now();
        }
        if ($request->status === 'shipped' && ! $order->shipped_at) {
            $updateData['shipped_at']       = now();
            $updateData['tracking_number']  = $request->tracking_number;
        }
        if ($request->admin_notes) {
            $updateData['admin_notes'] = $request->admin_notes;
        }

        $order->update($updateData);

        return back()->with('success', 'Status order diperbarui ke: ' . $order->fresh()->status_label);
    }
}
