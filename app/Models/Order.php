<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'shipping_city', 'shipping_province',
        'shipping_postal_code', 'shipping_country',
        'subtotal', 'shipping_cost', 'total', 'status',
        'payment_method', 'payment_proof', 'notes', 'admin_notes',
        'paid_at', 'shipped_at', 'tracking_number',
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'shipping_cost'=> 'decimal:2',
        'total'        => 'decimal:2',
        'paid_at'      => 'datetime',
        'shipped_at'   => 'datetime',
    ];

    const STATUS_LABELS = [
        'pending'    => 'Menunggu Konfirmasi',
        'confirmed'  => 'Dikonfirmasi',
        'paid'       => 'Sudah Bayar',
        'processing' => 'Diproses',
        'shipped'    => 'Dikirim',
        'delivered'  => 'Diterima',
        'cancelled'  => 'Dibatalkan',
    ];

    const STATUS_COLORS = [
        'pending'    => 'yellow',
        'confirmed'  => 'blue',
        'paid'       => 'green',
        'processing' => 'purple',
        'shipped'    => 'indigo',
        'delivered'  => 'emerald',
        'cancelled'  => 'red',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'AR-' . date('Y') . '-' . str_pad(
                    (Order::whereYear('created_at', date('Y'))->count() + 1),
                    6, '0', STR_PAD_LEFT
                );
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function chatRoom(): HasOne
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
