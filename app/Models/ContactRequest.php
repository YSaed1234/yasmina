<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
