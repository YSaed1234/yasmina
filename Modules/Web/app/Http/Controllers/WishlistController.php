<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Modules\Web\Services\WishlistService;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function toggle(Product $product)
    {
        $vendor_id = request('vendor_id');
        $status = $this->wishlistService->toggleWishlist($product->id, $vendor_id);
        
        $message = $status === 'added' ? __('Product added to wishlist') : __('Product removed from wishlist');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        $vendor_id = request('vendor_id');
        $wishlistItems = $this->wishlistService->getWishlistItems($vendor_id);
        
        return view('web::profile.wishlist', compact('wishlistItems'));
    }
}
