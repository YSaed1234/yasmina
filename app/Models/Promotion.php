<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'vendor_id',
        'name_ar',
        'name_en',
        'type',
        'buy_product_id',
        'buy_quantity',
        'get_product_id',
        'get_quantity',
        'discount_type',
        'discount_value',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'discount_value' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function buyProduct()
    {
        return $this->belongsTo(Product::class, 'buy_product_id');
    }

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'get_product_id');
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
}
