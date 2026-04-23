<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();
        $vendor_id = request('vendor_id');
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->where('vendor_id', $vendor_id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'vendor_id' => $vendor_id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function index()
    {
        $vendor_id = request('vendor_id');
        $query = auth()->user()->wishlist();
        if ($vendor_id) {
            $query->where('vendor_id', $vendor_id);
        }
        $wishlistItems = $query->with('product.translations', 'product.currency')->latest()->get();
        return view('web::profile.wishlist', compact('wishlistItems'));
    }
}
