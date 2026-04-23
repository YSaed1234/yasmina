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
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()->with('product.translations', 'product.currency')->latest()->get();
        return view('web::profile.wishlist', compact('wishlistItems'));
    }
}
