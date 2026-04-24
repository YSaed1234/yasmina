<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'about_ar',
        'about_en',
        'phone',
        'phone_secondary',
        'email',
        'address',
        'facebook',
        'instagram',
        'twitter',
        'whatsapp',
        'about_image1',
        'about_image2',
        'status',
        'password',
        'referred_by_id',
        'order_threshold',
        'order_threshold_discount',
        'order_threshold_discount_type',
        'min_items_for_discount',
        'items_discount_amount',
        'items_discount_type',
        'free_shipping_threshold',
        'commission_type',
        'commission_value',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function getTotalCommissionAttribute()
    {
        return $this->orders()
            ->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)
            ->sum('commission_amount');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()
            ->where('status', 'confirmed')
            ->sum('amount');
    }

    public function getRemainingBalanceAttribute()
    {
        return $this->total_commission - $this->total_paid;
    }
}
