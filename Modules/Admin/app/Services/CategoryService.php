<?php

namespace Modules\Admin\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::with('translations')->orderBy('rank')->get();
    }

    public function storeCategory(array $data)
    {
        $category = new Category();
        $category->rank = $data['rank'] ?? 0;
        
        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale]['name'])) {
                $category->translateOrNew($locale)->name = $data[$locale]['name'];
            }
        }
        
        $category->save();
        return $category;
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->rank = $data['rank'] ?? $category->rank;
        
        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale]['name'])) {
                $category->translateOrNew($locale)->name = $data[$locale]['name'];
            }
        }
        
        $category->save();
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
