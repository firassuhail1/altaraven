<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'size', 'type', 'color', 'color_hex',
        'custom_option', 'price_modifier', 'sku', 'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'price_modifier' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(VariantStock::class);
    }

    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function getStockQuantityAttribute(): int
    {
        return $this->stock?->quantity ?? 0;
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->product->base_price + $this->price_modifier;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    public function getLabelAttribute(): string
    {
        return collect([$this->size, $this->type, $this->color])
            ->filter()->implode(' / ');
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock(): bool
    {
        $threshold = $this->stock?->low_stock_threshold ?? 5;
        return $this->stock_quantity > 0 && $this->stock_quantity <= $threshold;
    }
}
