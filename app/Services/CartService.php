<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const KEY = 'altaraven_cart';

    public function get(): array
    {
        return Session::get(self::KEY, []);
    }

    public function add(int $productId, int $variantId, int $quantity = 1): void
    {
        $cart = $this->get();
        $key  = "{$productId}_{$variantId}";

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $variant = ProductVariant::with('product')->findOrFail($variantId);
            $product = $variant->product;

            $cart[$key] = [
                'product_id'   => $productId,
                'variant_id'   => $variantId,
                'product_name' => $product->name,
                'variant_info' => $variant->label,
                'price'        => (float) $variant->final_price,
                'image'        => $product->primary_image_url,
                'quantity'     => $quantity,
            ];
        }

        Session::put(self::KEY, $cart);
    }

    public function update(string $key, int $quantity): void
    {
        $cart = $this->get();
        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
            }
            Session::put(self::KEY, $cart);
        }
    }

    public function remove(string $key): void
    {
        $cart = $this->get();
        unset($cart[$key]);
        Session::put(self::KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::KEY);
    }

    public function total(): float
    {
        return array_sum(array_map(
            fn($item) => $item['price'] * $item['quantity'],
            $this->get()
        ));
    }

    public function count(): int
    {
        return array_sum(array_column($this->get(), 'quantity'));
    }

    public function isEmpty(): bool
    {
        return empty($this->get());
    }

    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total(), 0, ',', '.');
    }
}
