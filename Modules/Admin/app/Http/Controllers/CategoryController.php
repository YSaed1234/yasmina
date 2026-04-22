<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::orderBy('rank')->get();
        return view('admin::categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin::categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'nullable|integer',
        ]);

        \App\Models\Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin::categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin::categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'nullable|integer',
        ]);

        $category = \App\Models\Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
