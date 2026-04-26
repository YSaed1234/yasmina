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
        $product = $this->productService->storeProduct($request->validated(), $vendor->id);

        // Handle Variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['color']) || !empty($variantData['size'])) {
                    $product->variants()->create([
                        'color' => $variantData['color'],
                        'size' => $variantData['size'],
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'] ?? 0,
                        'sku' => $variantData['sku'] ?? null,
                    ]);
                }
            }
        }

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
        $product->load('variants');

        return view('vendor::products.edit', compact('product', 'categories', 'currencies'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($product->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $this->productService->updateProduct($product, $request->validated());

        // Handle Variants Sync
        if ($request->has('variants')) {
            $variantIds = [];
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['color']) || !empty($variantData['size'])) {
                    $variant = $product->variants()->updateOrCreate(
                        ['id' => $variantData['id'] ?? null],
                        [
                            'color' => $variantData['color'],
                            'size' => $variantData['size'],
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'] ?? 0,
                            'sku' => $variantData['sku'] ?? null,
                        ]
                    );
                    $variantIds[] = $variant->id;
                }
            }
            // Delete variants not in the request
            $product->variants()->whereNotIn('id', $variantIds)->delete();
        } else {
            // If no variants in request, maybe they were all deleted
            $product->variants()->delete();
        }

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
