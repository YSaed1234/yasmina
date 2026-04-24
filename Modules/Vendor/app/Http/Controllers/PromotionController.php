<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $vendor = auth('vendor')->user();
        $promotions = Promotion::where('vendor_id', $vendor->id)
            ->with(['buyProduct', 'getProduct'])
            ->latest()
            ->paginate(10);

        return view('vendor::promotions.index', compact('promotions'));
    }

    public function create()
    {
        $vendor = auth('vendor')->user();
        $products = Product::where('vendor_id', $vendor->id)->get();
        return view('vendor::promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $vendor = auth('vendor')->user();

        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'type' => 'required|in:bogo_same,bogo_different',
            'buy_product_id' => 'required|exists:products,id',
            'buy_quantity' => 'required|integer|min:1',
            'get_product_id' => 'required_if:type,bogo_different|nullable|exists:products,id',
            'get_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed,free',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['vendor_id'] = $vendor->id;
        $data['is_active'] = $request->has('is_active');
        
        if ($data['type'] == 'bogo_same') {
            $data['get_product_id'] = $data['buy_product_id'];
        }

        Promotion::create($data);

        return redirect()->route('vendor.promotions.index')->with('success', __('Promotion created successfully.'));
    }

    public function show($id)
    {
        return view('vendor::show');
    }

    public function edit(Promotion $promotion)
    {
        if ($promotion->vendor_id !== auth('vendor')->id()) {
            abort(403);
        }

        $vendor = auth('vendor')->user();
        $products = Product::where('vendor_id', $vendor->id)->get();
        return view('vendor::promotions.edit', compact('promotion', 'products'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        if ($promotion->vendor_id !== auth('vendor')->id()) {
            abort(403);
        }

        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'type' => 'required|in:bogo_same,bogo_different',
            'buy_product_id' => 'required|exists:products,id',
            'buy_quantity' => 'required|integer|min:1',
            'get_product_id' => 'required_if:type,bogo_different|nullable|exists:products,id',
            'get_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed,free',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($data['type'] == 'bogo_same') {
            $data['get_product_id'] = $data['buy_product_id'];
        }

        $promotion->update($data);

        return redirect()->route('vendor.promotions.index')->with('success', __('Promotion updated successfully.'));
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->vendor_id !== auth('vendor')->id()) {
            abort(403);
        }

        $promotion->delete();

        return redirect()->route('vendor.promotions.index')->with('success', __('Promotion deleted successfully.'));
    }
}
