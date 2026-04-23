<?php

namespace Modules\Admin\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories(array $filters = [])
    {
        $query = Category::with('translations')->orderBy('rank');

        $user = auth()->user();
        if ($user && $user->vendor_id) {
            // Vendor: see global categories AND their own categories
            $query->where(function($q) use ($user) {
                $q->whereNull('vendor_id')
                  ->orWhere('vendor_id', $user->vendor_id);
            });
        }

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
        
        $user = auth()->user();
        if ($user && $user->vendor_id) {
            $category->vendor_id = $user->vendor_id;
        } else {
            $category->vendor_id = $data['vendor_id'] ?? null;
        }
        
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
        
        $user = auth()->user();
        if ($user && $user->vendor_id) {
            // Vendors can't change vendor_id
        } else {
            $category->vendor_id = $data['vendor_id'] ?? $category->vendor_id;
        }
        
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
