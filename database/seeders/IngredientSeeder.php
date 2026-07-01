<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Chicken',      'icon' => '🍗'],
            ['name' => 'Brown Rice',   'icon' => '🍚'],
            ['name' => 'Broccoli',     'icon' => '🥦'],
            ['name' => 'Olive Oil',    'icon' => '🫒'],
            ['name' => 'Tuna',         'icon' => '🐟'],
            ['name' => 'Lettuce',      'icon' => '🥬'],
            ['name' => 'Tomato',       'icon' => '🍅'],
            ['name' => 'Lemon',        'icon' => '🍋'],
            ['name' => 'Egg',          'icon' => '🥚'],
            ['name' => 'Salmon',       'icon' => '🐠'],
            ['name' => 'Quinoa',       'icon' => '🌾'],
            ['name' => 'Spinach',      'icon' => '🥬'],
            ['name' => 'Avocado',      'icon' => '🥑'],
            ['name' => 'Beef',         'icon' => '🥩'],
            ['name' => 'Pasta',        'icon' => '🍝'],
            ['name' => 'Zucchini',     'icon' => '🥒'],
            ['name' => 'Garlic',       'icon' => '🧄'],
            ['name' => 'Onion',        'icon' => '🧅'],
            ['name' => 'Pepper',       'icon' => '🌶️'],
            ['name' => 'Greek Yogurt', 'icon' => '🥛'],
            ['name' => 'Banana',       'icon' => '🍌'],
            ['name' => 'Strawberry',   'icon' => '🍓'],
            ['name' => 'Mango',        'icon' => '🥭'],
            ['name' => 'Almond Milk',  'icon' => '🥛'],
            ['name' => 'Lentils',      'icon' => '🫘'],
            ['name' => 'Tofu',         'icon' => '🧊'],
            ['name' => 'Cauliflower',  'icon' => '🥦'],
            ['name' => 'Cheese',       'icon' => '🧀'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
