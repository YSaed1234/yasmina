<?php

namespace Modules\Web\Services;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    public function toggleWishlist(int $productId, $vendorId)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('vendor_id', $vendorId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'vendor_id' => $vendorId,
            ]);
            return 'added';
        }
    }

    public function getWishlistItems($vendorId)
    {
        $query = Auth::user()->wishlist();
        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }
        return $query->with('product.translations', 'product.currency')->latest()->get();
    }
}
