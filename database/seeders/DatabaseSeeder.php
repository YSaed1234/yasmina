<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsSeeder::class);

        $currencies = [
            ['en' => ['name' => 'US Dollar'], 'ar' => ['name' => 'دولار أمريكي'], 'code' => 'USD', 'symbol' => '$'],
            ['en' => ['name' => 'Euro'], 'ar' => ['name' => 'يورو'], 'code' => 'EUR', 'symbol' => '€'],
            ['en' => ['name' => 'Egyptian Pound'], 'ar' => ['name' => 'جنيه مصري'], 'code' => 'EGP', 'symbol' => 'LE'],
        ];

        foreach ($currencies as $curr) {
            $currency = new \App\Models\Currency();
            $currency->code = $curr['code'];
            $currency->symbol = $curr['symbol'];
            foreach (['en', 'ar'] as $locale) {
                $currency->translateOrNew($locale)->name = $curr[$locale]['name'];
            }
            $currency->save();
        }

        $usd = \App\Models\Currency::where('code', 'USD')->first();

        $categories = [
            ['en' => ['name' => 'Electronics'], 'ar' => ['name' => 'إلكترونيات'], 'rank' => 1],
            ['en' => ['name' => 'Fashion'], 'ar' => ['name' => 'أزياء'], 'rank' => 2],
            ['en' => ['name' => 'Home & Garden'], 'ar' => ['name' => 'المنزل والحديقة'], 'rank' => 3],
        ];

        foreach ($categories as $cat) {
            $category = new \App\Models\Category();
            $category->rank = $cat['rank'];
            foreach (['en', 'ar'] as $locale) {
                $category->translateOrNew($locale)->name = $cat[$locale]['name'];
            }
            $category->save();

            for ($i = 1; $i <= 3; $i++) {
                $product = new \App\Models\Product();
                $product->category_id = $category->id;
                $product->currency_id = $usd->id;
                $product->price = rand(100, 1000);
                $product->rank = $i;
                
                $product->translateOrNew('en')->name = $cat['en']['name'] . " Product " . $i;
                $product->translateOrNew('en')->description = "This is a description for " . $cat['en']['name'] . " Product " . $i;
                
                $product->translateOrNew('ar')->name = $cat['ar']['name'] . " منتج " . $i;
                $product->translateOrNew('ar')->description = "هذا وصف للمنتج " . $cat['ar']['name'] . " رقم " . $i;
                
                $product->save();
            }
        }
    }
}
