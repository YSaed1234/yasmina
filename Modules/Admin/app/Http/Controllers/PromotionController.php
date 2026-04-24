<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with(['vendor', 'buyProduct', 'getProduct'])->latest()->paginate(10);
        return view('admin::promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::where('is_gift', false)->get();
        $vendors = Vendor::all();
        return view('admin::promotions.create', compact('products', 'vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:vendors,id',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'type' => 'required|in:bogo_same,bogo_different',
            'buy_product_id' => 'required|exists:products,id',
            'buy_quantity' => 'required|integer|min:1',
            'get_product_id' => 'required_if:type,bogo_different|nullable|exists:products,id',
            'get_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed,free',
            'discount_value' => 'required_unless:discount_type,free|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        if ($validated['type'] === 'bogo_same') {
            $validated['get_product_id'] = $validated['buy_product_id'];
        }

        if ($validated['discount_type'] === 'free') {
            $validated['discount_value'] = 0;
        }

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')->with('success', __('Promotion created successfully.'));
    }

    public function edit(Promotion $promotion)
    {
        $products = Product::where('is_gift', false)->get();
        $vendors = Vendor::all();
        return view('admin::promotions.edit', compact('promotion', 'products', 'vendors'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:vendors,id',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'type' => 'required|in:bogo_same,bogo_different',
            'buy_product_id' => 'required|exists:products,id',
            'buy_quantity' => 'required|integer|min:1',
            'get_product_id' => 'required_if:type,bogo_different|nullable|exists:products,id',
            'get_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed,free',
            'discount_value' => 'required_unless:discount_type,free|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        if ($validated['type'] === 'bogo_same') {
            $validated['get_product_id'] = $validated['buy_product_id'];
        }

        if ($validated['discount_type'] === 'free') {
            $validated['discount_value'] = 0;
        }

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')->with('success', __('Promotion updated successfully.'));
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', __('Promotion deleted successfully.'));
    }
}
