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
        'phone',
        'email',
        'address',
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
