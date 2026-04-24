<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = [
        'category_id',
        'vendor_id',
        'price',
        'discount_price',
        'flash_sale_price',
        'flash_sale_expires_at',
        'is_gift',
        'gift_threshold',
        'currency_id',
        'rank',
        'image'
    ];

    protected $casts = [
        'is_gift' => 'boolean',
        'flash_sale_expires_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if the product has an active flash sale.
     */
    public function hasActiveFlashSale(): bool
    {
        return $this->flash_sale_price && 
               $this->flash_sale_expires_at && 
               $this->flash_sale_expires_at->isFuture();
    }

    /**
     * Get the effective price of the product (Flash Sale > Discount > Regular).
     */
    public function getEffectivePriceAttribute()
    {
        if ($this->hasActiveFlashSale()) {
            return $this->flash_sale_price;
        }

        if ($this->discount_price && $this->discount_price < $this->price) {
            return $this->discount_price;
        }

        return $this->price;
    }

    /**
     * Check if the product is on any kind of sale.
     */
    public function isSale(): bool
    {
        return $this->hasActiveFlashSale() || ($this->discount_price && $this->discount_price < $this->price);
    }
}
