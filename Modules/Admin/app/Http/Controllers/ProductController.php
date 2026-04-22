<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreProductRequest;
use Modules\Admin\Http\Requests\UpdateProductRequest;
use Modules\Admin\Services\CategoryService;
use Modules\Admin\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
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
        return view('admin::products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->storeProduct($request->validated());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
        return view('admin::products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->updateProduct($product, $request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = $this->productService->findProduct($id);
        $this->productService->deleteProduct($product);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
