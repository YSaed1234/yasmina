<?php

namespace App\Enums;

enum ProductBadge: string
{
    case BEST_SELLER = 'Best Seller';
    case EXCLUSIVE = 'Exclusive';
    case LIMITED_EDITION = 'Limited Edition';
    case TRENDING = 'Trending';

    public function label(): string
    {
        return match($this) {
            self::BEST_SELLER => __('Best Seller'),
            self::EXCLUSIVE => __('Exclusive'),
            self::LIMITED_EDITION => __('Limited Edition'),
            self::TRENDING => __('Trending'),
        };
    }
}
