<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Show categories belonging to this vendor OR global categories
        $categories = Category::where(function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id)
              ->orWhereNull('vendor_id');
        })
        ->with('translations')
        ->latest()
        ->paginate(10);

        return view('vendor::categories.index', compact('categories'));
    }

    public function create()
    {
        return view('vendor::categories.create');
    }

    public function store(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        
        $request->validate([
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->vendor_id = $vendor->id;
        $category->rank = 0;

        foreach (['ar', 'en'] as $locale) {
            if ($request->has($locale)) {
                $category->translateOrNew($locale)->name = $request->input("$locale.name");
            }
        }

        $category->save();

        return redirect()->route('vendor.categories.index')->with('success', __('Category created successfully.'));
    }

    public function edit(Category $category)
    {
        // Vendors can only edit their OWN categories. Global categories are read-only for them.
        if ($category->vendor_id !== Auth::guard('vendor')->id()) {
            return redirect()->route('vendor.categories.index')->with('error', __('You cannot edit global categories.'));
        }

        return view('vendor::categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $request->validate([
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
        ]);

        foreach (['ar', 'en'] as $locale) {
            if ($request->has($locale)) {
                $category->translateOrNew($locale)->name = $request->input("$locale.name");
            }
        }

        $category->save();

        return redirect()->route('vendor.categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(Category $category)
    {
        if ($category->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('vendor.categories.index')->with('success', __('Category deleted successfully.'));
    }
}
