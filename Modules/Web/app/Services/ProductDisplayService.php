<?php

namespace Modules\Web\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Http\Request;

class ProductDisplayService
{
    public function getShopData(Request $request, $vendorId)
    {
        $query = Product::with(['category', 'currency']);

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        } else {
            $query->whereNull('vendor_id');
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereTranslationLike('name', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by currency
        if ($request->filled('currency_id')) {
            $query->where('currency_id', $request->currency_id);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->orderBy('rank')->paginate(12)->withQueryString();
        
        $categoriesQuery = Category::query();
        if ($vendorId) {
            $categoriesQuery->where('vendor_id', $vendorId);
        } else {
            $categoriesQuery->whereNull('vendor_id');
        }
        $categories = $categoriesQuery->get();
        
        $currencies = Currency::all();

        return compact('products', 'categories', 'currencies');
    }

    public function getProductDetails($id, $vendorId = null)
    {
        $product = Product::with(['category', 'currency'])->findOrFail($id);
        
        // If a vendor is specified, ensure the product belongs to it
        if ($vendorId && $product->vendor_id != $vendorId) {
            return null;
        }
        
        return $product;
    }
}
