<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $usd = Currency::where('code', 'USD')->first() ?? Currency::first();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        // Fix existing products without translations
        $existingProducts = Product::all();
        foreach ($existingProducts as $product) {
            foreach (['en', 'ar'] as $locale) {
                if (!$product->hasTranslation($locale)) {
                    $product->translateOrNew($locale)->name = ($locale == 'ar' ? 'منتج عشوائي ' : 'Random Product ') . rand(100, 999);
                    $product->translateOrNew($locale)->description = ($locale == 'ar' ? 'وصف عشوائي للمنتج' : 'Random product description');
                }
            }
            $product->save();
        }

        // Add new products to categories
        foreach ($categories as $category) {
            for ($i = 1; $i <= 2; $i++) {
                $product = new Product();
                $product->category_id = $category->id;
                $product->currency_id = $usd->id;
                $product->price = rand(500, 5000);
                $product->rank = rand(1, 10);
                
                $nameEn = $category->translate('en')?->name ?? 'Category';
                $nameAr = $category->translate('ar')?->name ?? 'قسم';

                $product->translateOrNew('en')->name = "Premium " . $nameEn . " Item " . rand(1, 100);
                $product->translateOrNew('en')->description = "Experience the ultimate luxury with our " . $nameEn . " collection.";
                
                $product->translateOrNew('ar')->name = $nameAr . " فاخر قطعه " . rand(1, 100);
                $product->translateOrNew('ar')->description = "استمتع بالفخامة المطلقة مع مجموعة الـ " . $nameAr . " الخاصة بنا.";
                
                $product->save();
            }
        }
    }
}
