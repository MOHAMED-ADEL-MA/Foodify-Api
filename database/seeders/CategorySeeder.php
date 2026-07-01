<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'High Protein'],
            ['name' => 'Low Calorie'],
            ['name' => 'Balanced Meals'],
            ['name' => 'Smoothies'],
            ['name' => 'Vegan'],
            ['name' => 'Keto'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
