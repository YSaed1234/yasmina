<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'shipping_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_details',
        'notes',
    ];

    protected $casts = [
        'shipping_details' => 'array',
        'total' => 'decimal:2',
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
