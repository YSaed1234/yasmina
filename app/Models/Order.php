<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'total',
        'shipping_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_details',
        'notes',
        'rejection_reason',
        'coupon_id',
        'discount_amount',
        'vendor_discount_amount',
        'vendor_discount_type',
        'promotional_discount_amount',
        'commission_amount',
        'vendor_net_amount',
    ];

    protected $casts = [
        'shipping_details' => 'array',
        'total' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'vendor_net_amount' => 'decimal:2',
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
