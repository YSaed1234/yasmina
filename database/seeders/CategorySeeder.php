<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Fix existing data without translations
        $existingCategories = Category::all();
        foreach ($existingCategories as $category) {
            foreach (['en', 'ar'] as $locale) {
                if (!$category->hasTranslation($locale)) {
                    $category->translateOrNew($locale)->name = ($locale == 'ar' ? 'قسم عشوائي ' : 'Random Category ') . rand(100, 999);
                }
            }
            $category->save();
        }

        // Add new categories
        $newCategories = [
            ['en' => ['name' => 'Watches'], 'ar' => ['name' => 'ساعات'], 'rank' => 4],
            ['en' => ['name' => 'Jewelry'], 'ar' => ['name' => 'مجوهرات'], 'rank' => 5],
            ['en' => ['name' => 'Beauty'], 'ar' => ['name' => 'جمال'], 'rank' => 6],
        ];

        foreach ($newCategories as $cat) {
            $category = new Category();
            $category->rank = $cat['rank'];
            foreach (['en', 'ar'] as $locale) {
                $category->translateOrNew($locale)->name = $cat[$locale]['name'];
            }
            $category->save();
        }
    }
}
