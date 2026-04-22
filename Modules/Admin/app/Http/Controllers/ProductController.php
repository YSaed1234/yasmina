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
            new Middleware('permission:edit products|manage products', only: ['edit', 'update']),
            new Middleware('permission:delete products|manage products', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('admin::products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $currencies = $this->currencyService->getAllCurrencies();
        return view('admin::products.create', compact('categories', 'currencies'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->storeProduct($request->validated());

        return redirect()->route('products.index')->with('success', __('Product created successfully.'));
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
        return view('admin::products.edit', compact('product', 'categories', 'currencies'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->updateProduct($product, $request->validated());

        return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->deleteProduct($product);

        return redirect()->route('products.index')->with('success', __('Product deleted successfully.'));
    }
}
