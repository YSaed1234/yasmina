<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $products = Product::where('vendor_id', $vendor->id)
            ->with(['category', 'translations'])
            ->latest()
            ->paginate(10);

        return view('vendor::products.index', compact('products'));
    }

    public function create()
    {
        $vendor = Auth::guard('vendor')->user();
        // Get categories belonging to this vendor OR global categories (where vendor_id is null)
        $categories = Category::where(function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id)
              ->orWhereNull('vendor_id');
        })->get();

        return view('vendor::products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'ar.description' => 'nullable|string',
            'en.description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product();
        $product->vendor_id = $vendor->id;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->currency_id = 1; // Default currency for now

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        foreach (['ar', 'en'] as $locale) {
            if ($request->has($locale)) {
                $product->translateOrNew($locale)->name = $request->input("$locale.name");
                $product->translateOrNew($locale)->description = $request->input("$locale.description");
            }
        }

        $product->save();

        return redirect()->route('vendor.products.index')->with('success', __('Product created successfully.'));
    }

    public function edit(Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $vendor = Auth::guard('vendor')->user();
        $categories = Category::where(function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id)
              ->orWhereNull('vendor_id');
        })->get();

        return view('vendor::products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'ar.description' => 'nullable|string',
            'en.description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->category_id = $request->category_id;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        foreach (['ar', 'en'] as $locale) {
            if ($request->has($locale)) {
                $product->translateOrNew($locale)->name = $request->input("$locale.name");
                $product->translateOrNew($locale)->description = $request->input("$locale.description");
            }
        }

        $product->save();

        return redirect()->route('vendor.products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', __('Product deleted successfully.'));
    }
}
