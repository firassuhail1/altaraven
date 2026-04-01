<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantStock extends Model
{
    protected $fillable = ['product_variant_id', 'quantity', 'low_stock_threshold'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function adjust(int $change, string $reason = 'manual', ?int $adminId = null): StockAdjustment
    {
        $before = $this->quantity;
        $this->quantity = max(0, $this->quantity + $change);
        $this->save();

        return StockAdjustment::create([
            'product_variant_id' => $this->product_variant_id,
            'user_id'            => $adminId,
            'quantity_change'    => $change,
            'quantity_before'    => $before,
            'quantity_after'     => $this->quantity,
            'reason'             => $reason,
        ]);
    }
}
