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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@yasmina.com',
            'password' => bcrypt('password'),
        ]);

        $currencies = [
            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$'],
            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€'],
            ['name' => 'Egyptian Pound', 'code' => 'EGP', 'symbol' => 'LE'],
        ];

        foreach ($currencies as $curr) {
            \App\Models\Currency::create($curr);
        }

        $usd = \App\Models\Currency::where('code', 'USD')->first();

        $categories = [
            ['name' => 'Electronics', 'rank' => 1],
            ['name' => 'Fashion', 'rank' => 2],
            ['name' => 'Home & Garden', 'rank' => 3],
        ];

        foreach ($categories as $cat) {
            $category = \App\Models\Category::create($cat);

            for ($i = 1; $i <= 3; $i++) {
                \App\Models\Product::create([
                    'category_id' => $category->id,
                    'currency_id' => $usd->id,
                    'name' => $cat['name'] . " Product " . $i,
                    'description' => "This is a description for " . $cat['name'] . " Product " . $i,
                    'price' => rand(100, 1000),
                    'rank' => $i,
                ]);
            }
        }
    }
}
