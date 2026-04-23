<?php

namespace Modules\Admin\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories(array $filters = [])
    {
        $query = Category::with('translations')->orderBy('rank');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereTranslationLike('name', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 10);
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
