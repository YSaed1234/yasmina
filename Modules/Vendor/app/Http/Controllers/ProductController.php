<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Vendor\Http\Requests\StoreProductRequest;
use Modules\Vendor\Http\Requests\UpdateProductRequest;
use Modules\Vendor\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $products = $this->productService->getVendorProducts($vendor->id);

        return view('vendor::products.index', compact('products'));
    }

    public function create()
    {
        $vendor = Auth::guard('vendor')->user();
        $categories = Category::where('vendor_id', $vendor->id)->get();
        $currencies = Currency::all();

        return view('vendor::products.create', compact('categories', 'currencies'));
    }

    public function store(StoreProductRequest $request)
    {
        $vendor = Auth::guard('vendor')->user();
        $this->productService->storeProduct($request->validated(), $vendor->id);

        return redirect()->route('vendor.products.index')->with('success', __('Product created successfully.'));
    }

    public function edit(Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $vendor = Auth::guard('vendor')->user();
        $categories = Category::where('vendor_id', $vendor->id)->get();
        $currencies = Currency::all();

        return view('vendor::products.edit', compact('product', 'categories', 'currencies'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $this->productService->updateProduct($product, $request->validated());

        return redirect()->route('vendor.products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $this->productService->deleteProduct($product);

        return redirect()->route('vendor.products.index')->with('success', __('Product deleted successfully.'));
    }

    public function updateStock(Request $request, Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            return response()->json(['success' => false, 'message' => __('Unauthorized')], 403);
        }

        $validated = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->update(['stock' => $validated['stock']]);

        return response()->json([
            'success' => true, 
            'message' => __('Stock updated successfully'),
            'stock' => $product->stock
        ]);
    }
}
