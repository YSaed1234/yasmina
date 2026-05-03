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
        'product_commission_type',
        'product_commission_value',
        'primary_color',
        'secondary_color',
        'return_policy_ar',
        'return_policy_en',
        'subscription_fees',
        'manager_name',
        'manager_id_number',
        'manager_phone',
        'contract_signed_at',
        'setup_fee',
    ];
    
    protected $casts = [
        'contract_signed_at' => 'date',
        'commission_value' => 'decimal:2',
        'product_commission_value' => 'decimal:2',
        'order_threshold' => 'decimal:2',
        'order_threshold_discount' => 'decimal:2',
        'items_discount_amount' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'subscription_fees' => 'decimal:2',
        'setup_fee' => 'decimal:2',
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
