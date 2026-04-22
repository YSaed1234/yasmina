<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreCategoryRequest;
use Modules\Admin\Http\Requests\UpdateCategoryRequest;
use Modules\Admin\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin::categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin::categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->storeCategory($request->validated());

        return redirect()->route('categories.index')->with('success', __('Category created successfully.'));
    }

    public function show(string $id)
    {
        $category = $this->categoryService->findCategory($id);
        return view('admin::categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = $this->categoryService->findCategory($id);
        return view('admin::categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = $this->categoryService->findCategory($id);
        $this->categoryService->updateCategory($category, $request->validated());

        return redirect()->route('categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(string $id)
    {
        $category = $this->categoryService->findCategory($id);
        $this->categoryService->deleteCategory($category);

        return redirect()->route('categories.index')->with('success', __('Category deleted successfully.'));
    }
}
