<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::NEW => __('new'),
            self::PROCESSING => __('processing'),
            self::SHIPPED => __('shipped'),
            self::DELIVERED => __('delivered'),
            self::CANCELLED => __('cancelled'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'bg-blue-50 text-blue-600',
            self::PROCESSING => 'bg-amber-50 text-amber-600',
            self::SHIPPED => 'bg-indigo-50 text-indigo-600',
            self::DELIVERED => 'bg-green-50 text-green-600',
            self::CANCELLED => 'bg-red-50 text-red-600',
        };

    }

    public function chartColor(): string
    {
        return match ($this) {
            self::NEW => 'blue',
            self::PROCESSING => 'amber',
            self::SHIPPED => 'indigo',
            self::DELIVERED => 'emerald',
            self::CANCELLED => 'rose',
        };
    }
}
