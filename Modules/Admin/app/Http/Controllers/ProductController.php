<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreProductRequest;
use Modules\Admin\Http\Requests\UpdateProductRequest;
use Modules\Admin\Services\CategoryService;
use Modules\Admin\Services\CurrencyService;
use Modules\Admin\Services\ProductService;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    protected $productService;
    protected $categoryService;
    protected $currencyService;

    public function __construct(ProductService $productService, CategoryService $categoryService, CurrencyService $currencyService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->currencyService = $currencyService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view products|manage products', only: ['index', 'show']),
            new Middleware('permission:create products|manage products', only: ['create', 'store']),
            new Middleware('permission:edit products|manage products', only: ['edit', 'update', 'updateStock']),
            new Middleware('permission:delete products|manage products', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $products = $this->productService->getAllProducts($request->all());
        $categories = $this->categoryService->getAllCategories(['per_page' => 100]); // For filter dropdown
        return view('admin::products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $currencies = $this->currencyService->getAllCurrencies();
        $vendors = \App\Models\Vendor::all();
        return view('admin::products.create', compact('categories', 'currencies', 'vendors'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->storeProduct($request->validated());

        return redirect()->route('admin.products.index')->with('success', __('Product created successfully.'));
    }

    public function show(string $id)
    {
        $product = $this->productService->findProduct($id);
        return view('admin::products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = $this->productService->findProduct($id);
        $categories = $this->categoryService->getAllCategories();
        $currencies = $this->currencyService->getAllCurrencies();
        $vendors = \App\Models\Vendor::all();
        return view('admin::products.edit', compact('product', 'categories', 'currencies', 'vendors'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->updateProduct($product, $request->validated());

        return redirect()->route('admin.products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->deleteProduct($product);

        return redirect()->route('admin.products.index')->with('success', __('Product deleted successfully.'));
    }

    public function updateStock(\Illuminate\Http\Request $request, string $id)
    {
        $product = $this->productService->findProduct($id);
        
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
