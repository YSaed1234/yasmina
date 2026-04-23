<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreCategoryRequest;
use Modules\Admin\Http\Requests\UpdateCategoryRequest;
use Modules\Admin\Services\CategoryService;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view categories|manage categories', only: ['index', 'show']),
            new Middleware('permission:create categories|manage categories', only: ['create', 'store']),
            new Middleware('permission:edit categories|manage categories', only: ['edit', 'update']),
            new Middleware('permission:delete categories|manage categories', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->all());
        return view('admin::categories.index', compact('categories'));
    }

    public function create()
    {
        $vendors = \App\Models\Vendor::all();
        return view('admin::categories.create', compact('vendors'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->storeCategory($request->validated());

        return redirect()->route('admin.categories.index')->with('success', __('Category created successfully.'));
    }

    public function show(string $id)
    {
        $category = $this->categoryService->findCategory($id);
        return view('admin::categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = $this->categoryService->findCategory($id);
        
        $user = auth()->user();
        if ($user->vendor_id && $category->vendor_id !== $user->vendor_id) {
            abort(403, __('You cannot edit a global category.'));
        }

        $vendors = \App\Models\Vendor::all();
        return view('admin::categories.edit', compact('category', 'vendors'));
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = $this->categoryService->findCategory($id);

        $user = auth()->user();
        if ($user->vendor_id && $category->vendor_id !== $user->vendor_id) {
            abort(403, __('You cannot update a global category.'));
        }

        $this->categoryService->updateCategory($category, $request->validated());

        return redirect()->route('admin.categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(string $id)
    {
        $category = $this->categoryService->findCategory($id);

        $user = auth()->user();
        if ($user->vendor_id && $category->vendor_id !== $user->vendor_id) {
            abort(403, __('You cannot delete a global category.'));
        }

        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories.index')->with('success', __('Category deleted successfully.'));
    }
}
