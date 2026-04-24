<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            'القاهرة',
            'الجيزة',
            'الإسكندرية',
            'الدقهلية',
            'البحر الأحمر',
            'البحيرة',
            'الفيوم',
            'الغربية',
            'الإسماعيلية',
            'المنوفية',
            'المنيا',
            'القليوبية',
            'الوادي الجديد',
            'الشرقية',
            'السويس',
            'أسوان',
            'أسيوط',
            'بني سويف',
            'بورسعيد',
            'دمياط',
            'جنوب سيناء',
            'كفر الشيخ',
            'مطروح',
            'قنا',
            'شمال سيناء',
            'سوهاج',
            'الأقصر'
        ];

        foreach ($governorates as $name) {
            \App\Models\Governorate::updateOrCreate(['name' => $name]);
        }
    }
}
