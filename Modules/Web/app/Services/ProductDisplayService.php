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
        $query = Product::withValidPrice()->with(['category', 'currency']);

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

        $slidesQuery = \App\Models\Slide::where('active', true);
        if ($vendorId) {
            $slidesQuery->where('vendor_id', $vendorId);
        } else {
            $slidesQuery->whereNull('vendor_id');
        }
        $slides = $slidesQuery->orderBy('order')->get();

        return compact('products', 'categories', 'currencies', 'slides');
    }

    public function getProductDetails($id, $vendorId = null)
    {
        $product = Product::
            withValidPrice()->
            with(['category', 'currency', 'variants'])
            ->find($id);

        if (!$product) {
            return null;
        }

        // If a vendor is specified, ensure the product belongs to it
        if ($vendorId && $product->vendor_id != $vendorId) {
            return null;
        }


        return $product;
    }
    public function getPromotionDetails($id, $vendorId = null)
    {
        $promotion = \App\Models\Promotion::with(['buyProduct', 'getProduct'])
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->find($id);

        if (!$promotion) {
            return null;
        }

        if ($vendorId && $promotion->vendor_id != $vendorId) {
            return null;
        }

        return $promotion;
    }

    public function getPromotionsData(Request $request, $vendorId)
    {
        $query = \App\Models\Promotion::with(['buyProduct', 'getProduct'])
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        } else {
            $query->whereNull('vendor_id');
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereTranslationLike('name', '%' . $request->search . '%');
        }

        // Filtering by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $promotions = $query->latest()->paginate(12)->withQueryString();

        return compact('promotions');
    }
}
