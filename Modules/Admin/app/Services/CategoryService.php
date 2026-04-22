<?php

namespace Modules\Admin\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::orderBy('rank')->get();
    }

    public function storeCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }

    public function findCategory(string $id)
    {
        return Category::findOrFail($id);
    }
}
