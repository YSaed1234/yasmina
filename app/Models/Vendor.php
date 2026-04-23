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
}
