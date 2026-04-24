<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'balance',
        'role',
        'profile_image',
        'phone',
        'referral_code',
        'referred_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(\Illuminate\Support\Str::random(8));
            }
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function pointTransactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function convertPointsToBalance(int $pointsToConvert)
    {
        $minPoints = (int) PointSetting::getValue('min_points_to_convert', 100);

        if ($pointsToConvert < $minPoints) {
            throw new \Exception(__('Minimum points to convert is :min', ['min' => $minPoints]));
        }

        if ($this->points < $pointsToConvert) {
            throw new \Exception(__('Insufficient points balance.'));
        }

        $rate = (float) PointSetting::getValue('currency_per_point', 0.1);
        $moneyValue = $pointsToConvert * $rate;

        return \DB::transaction(function () use ($pointsToConvert, $moneyValue) {
            $this->subtractPoints($pointsToConvert, 'spending', __('Converted to wallet balance'));
            $this->increment('balance', $moneyValue);

            return $moneyValue;
        });
    }

    public function addPoints(int $points, string $type, string $description = null, $reference = null)
    {
        $this->increment('points', $points);

        return $this->pointTransactions()->create([
            'points' => $points,
            'type' => $type,
            'description' => $description,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference ? $reference->id : null,
        ]);
    }

    public function subtractPoints(int $points, string $type, string $description = null, $reference = null)
    {
        if ($this->points < $points) {
            throw new \Exception('Insufficient points balance.');
        }

        $this->decrement('points', $points);

        return $this->pointTransactions()->create([
            'points' => -$points,
            'type' => $type,
            'description' => $description,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference ? $reference->id : null,
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function vendorNotifications($vendorId = null)
    {
        $query = $this->notifications();
        if ($vendorId) {
            if (!is_numeric($vendorId)) {
                $vendorId = \App\Models\Vendor::where('slug', $vendorId)->value('id');
            }
            $query->where('vendor_id', (int) $vendorId);
        }
        return $query;
    }

    public function vendorUnreadNotifications($vendorId = null)
    {
        $query = $this->unreadNotifications();
        if ($vendorId) {
            if (!is_numeric($vendorId)) {
                $vendorId = \App\Models\Vendor::where('slug', $vendorId)->value('id');
            }
            $query->where('vendor_id', (int) $vendorId);
        }
        return $query;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
