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
}
