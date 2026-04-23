<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductDisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendor_id = $request->get('vendor_id');
        $query = \App\Models\Product::with(['category', 'currency']);

        if ($vendor_id) {
            $query->where('vendor_id', $vendor_id);
        } else {
            $query->whereNull('vendor_id');
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->whereTranslationLike('name', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by currency
        if ($request->has('currency_id') && $request->currency_id != '') {
            $query->where('currency_id', $request->currency_id);
        }

        // Price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->orderBy('rank')->paginate(12)->withQueryString();
        
        $categoriesQuery = \App\Models\Category::query();
        if ($vendor_id) {
            $categoriesQuery->where('vendor_id', $vendor_id);
        } else {
            $categoriesQuery->whereNull('vendor_id');
        }
        $categories = $categoriesQuery->get();
        
        $currencies = \App\Models\Currency::all();

        return view('web::shop', compact('products', 'categories', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {
        $vendor_id = $request->get('vendor_id');
        $query = \App\Models\Product::with(['category', 'currency']);
        
        if ($vendor_id) {
            $query->where('vendor_id', $vendor_id);
        } else {
            $query->whereNull('vendor_id');
        }

        $product = $query->findOrFail($id);
        return view('web::show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('web::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
