<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $meals = [
            // ─── High Protein ───────────────────────────
            [
                'category' => 'High Protein',
                'name'        => 'Grilled Chicken Bowl',
                'description' => 'Grilled chicken breast with brown rice, steamed broccoli, and light lemon dressing.',
                'price'       => 120.00,
                'calories'    => 450,
                'protein'     => 38,
                'carbs'       => 35,
                'fat'         => 10,
                'fiber'       => 5,
                'rating'      => 4.5,
                'ingredients' => ['Chicken', 'Brown Rice', 'Broccoli', 'Lemon', 'Olive Oil'],
            ],
            [
                'category' => 'High Protein',
                'name'        => 'Beef & Quinoa Pasta',
                'description' => 'Lean beef with quinoa pasta and fresh tomato sauce.',
                'price'       => 100.00,
                'calories'    => 520,
                'protein'     => 40,
                'carbs'       => 42,
                'fat'         => 14,
                'fiber'       => 6,
                'rating'      => 4.0,
                'ingredients' => ['Beef', 'Quinoa', 'Pasta', 'Tomato', 'Garlic', 'Olive Oil'],
            ],
            [
                'category' => 'High Protein',
                'name'        => 'Tuna Power Salad',
                'description' => 'A refreshing protein-rich salad made with fresh tuna, avocado, spinach, and light lemon dressing, perfect for a healthy energizing meal.',
                'price'       => 120.00,
                'calories'    => 85,
                'protein'     => 30,
                'carbs'       => 12,
                'fat'         => 11,
                'fiber'       => 6,
                'rating'      => 4.5,
                'ingredients' => ['Tuna', 'Lettuce', 'Tomato', 'Avocado', 'Lemon', 'Olive Oil'],
            ],

            // ─── Low Calorie ────────────────────────────
            [
                'category' => 'Low Calorie',
                'name'        => 'Zucchini Noodles',
                'description' => 'Light zucchini noodles with fresh tomato sauce and herbs.',
                'price'       => 100.00,
                'calories'    => 180,
                'protein'     => 8,
                'carbs'       => 20,
                'fat'         => 6,
                'fiber'       => 4,
                'rating'      => 4.0,
                'ingredients' => ['Zucchini', 'Tomato', 'Garlic', 'Olive Oil'],
            ],
            [
                'category' => 'Low Calorie',
                'name'        => 'Grilled Veggie Wrap',
                'description' => 'Colorful grilled vegetables wrapped in a whole wheat tortilla.',
                'price'       => 90.00,
                'calories'    => 220,
                'protein'     => 9,
                'carbs'       => 32,
                'fat'         => 7,
                'fiber'       => 5,
                'rating'      => 4.0,
                'ingredients' => ['Zucchini', 'Pepper', 'Onion', 'Spinach', 'Olive Oil'],
            ],
            [
                'category' => 'Low Calorie',
                'name'        => 'Greek Yogurt Bowl',
                'description' => 'Creamy Greek yogurt topped with fresh fruits and honey.',
                'price'       => 80.00,
                'calories'    => 200,
                'protein'     => 15,
                'carbs'       => 25,
                'fat'         => 4,
                'fiber'       => 2,
                'rating'      => 4.5,
                'ingredients' => ['Greek Yogurt', 'Strawberry', 'Banana', 'Lemon'],
            ],

            // ─── Balanced Meals ─────────────────────────
            [
                'category' => 'Balanced Meals',
                'name'        => 'Grilled Chicken with Brown Rice',
                'description' => 'A perfectly balanced meal with grilled chicken, brown rice, and steamed vegetables.',
                'price'       => 120.00,
                'calories'    => 480,
                'protein'     => 35,
                'carbs'       => 45,
                'fat'         => 12,
                'fiber'       => 6,
                'rating'      => 4.5,
                'ingredients' => ['Chicken', 'Brown Rice', 'Broccoli', 'Olive Oil', 'Garlic'],
            ],
            [
                'category' => 'Balanced Meals',
                'name'        => 'Salmon & Quinoa Bowl',
                'description' => 'Fresh salmon fillet served with quinoa and roasted vegetables.',
                'price'       => 100.00,
                'calories'    => 510,
                'protein'     => 38,
                'carbs'       => 40,
                'fat'         => 15,
                'fiber'       => 7,
                'rating'      => 4.5,
                'ingredients' => ['Salmon', 'Quinoa', 'Spinach', 'Lemon', 'Olive Oil'],
            ],
            [
                'category' => 'Balanced Meals',
                'name'        => 'Beef Teriyaki Plate',
                'description' => 'Tender beef strips with teriyaki sauce served over steamed rice.',
                'price'       => 130.00,
                'calories'    => 550,
                'protein'     => 36,
                'carbs'       => 50,
                'fat'         => 16,
                'fiber'       => 4,
                'rating'      => 4.0,
                'ingredients' => ['Beef', 'Brown Rice', 'Garlic', 'Onion', 'Pepper'],
            ],

            // ─── Smoothies ──────────────────────────────
            [
                'category' => 'Smoothies',
                'name'        => 'Green Power Smoothie',
                'description' => 'Spinach, banana, kiwi, and almond milk blended into a nutritious drink.',
                'price'       => 120.00,
                'calories'    => 180,
                'protein'     => 8,
                'carbs'       => 30,
                'fat'         => 4,
                'fiber'       => 5,
                'rating'      => 4.0,
                'ingredients' => ['Spinach', 'Banana', 'Almond Milk', 'Lemon'],
            ],
            [
                'category' => 'Smoothies',
                'name'        => 'Berry Blast Smoothie',
                'description' => 'Mixed berries, yogurt, and chia seeds for a powerful antioxidant boost.',
                'price'       => 100.00,
                'calories'    => 200,
                'protein'     => 10,
                'carbs'       => 35,
                'fat'         => 3,
                'fiber'       => 6,
                'rating'      => 4.5,
                'ingredients' => ['Strawberry', 'Greek Yogurt', 'Banana', 'Almond Milk'],
            ],
            [
                'category' => 'Smoothies',
                'name'        => 'Mango Protein Shake',
                'description' => 'Fresh mango blended with protein powder and almond milk.',
                'price'       => 100.00,
                'calories'    => 220,
                'protein'     => 20,
                'carbs'       => 32,
                'fat'         => 3,
                'fiber'       => 3,
                'rating'      => 4.0,
                'ingredients' => ['Mango', 'Almond Milk', 'Banana', 'Greek Yogurt'],
            ],

            // ─── Vegan ──────────────────────────────────
            [
                'category' => 'Vegan',
                'name'        => 'Vegan Lentil Bowl',
                'description' => 'Hearty lentils with roasted vegetables and tahini dressing.',
                'price'       => 100.00,
                'calories'    => 380,
                'protein'     => 18,
                'carbs'       => 52,
                'fat'         => 8,
                'fiber'       => 14,
                'rating'      => 4.0,
                'ingredients' => ['Lentils', 'Tomato', 'Onion', 'Garlic', 'Olive Oil', 'Spinach'],
            ],
            [
                'category' => 'Vegan',
                'name'        => 'Tofu Stir-fry',
                'description' => 'Crispy tofu with colorful vegetables in a savory sauce.',
                'price'       => 90.00,
                'calories'    => 320,
                'protein'     => 16,
                'carbs'       => 28,
                'fat'         => 12,
                'fiber'       => 5,
                'rating'      => 4.0,
                'ingredients' => ['Tofu', 'Broccoli', 'Pepper', 'Garlic', 'Onion', 'Olive Oil'],
            ],
            [
                'category' => 'Vegan',
                'name'        => 'Falafel Plate',
                'description' => 'Crispy falafel served with fresh salad and tahini sauce.',
                'price'       => 80.00,
                'calories'    => 400,
                'protein'     => 14,
                'carbs'       => 48,
                'fat'         => 16,
                'fiber'       => 8,
                'rating'      => 4.5,
                'ingredients' => ['Lentils', 'Onion', 'Garlic', 'Pepper', 'Lettuce', 'Tomato'],
            ],

            // ─── Keto ───────────────────────────────────
            [
                'category' => 'Keto',
                'name'        => 'Keto Chicken Alfredo',
                'description' => 'Creamy chicken alfredo with zucchini noodles instead of pasta.',
                'price'       => 120.00,
                'calories'    => 480,
                'protein'     => 35,
                'carbs'       => 8,
                'fat'         => 34,
                'fiber'       => 3,
                'rating'      => 4.5,
                'ingredients' => ['Chicken', 'Zucchini', 'Cheese', 'Garlic', 'Olive Oil'],
            ],
            [
                'category' => 'Keto',
                'name'        => 'Zucchini Lasagna',
                'description' => 'Classic lasagna made with zucchini sheets instead of pasta.',
                'price'       => 100.00,
                'calories'    => 420,
                'protein'     => 28,
                'carbs'       => 10,
                'fat'         => 30,
                'fiber'       => 4,
                'rating'      => 4.0,
                'ingredients' => ['Zucchini', 'Beef', 'Tomato', 'Cheese', 'Garlic', 'Onion'],
            ],
            [
                'category' => 'Keto',
                'name'        => 'Cauliflower Rice Bowl',
                'description' => 'Cauliflower rice with grilled chicken and avocado.',
                'price'       => 110.00,
                'calories'    => 390,
                'protein'     => 32,
                'carbs'       => 12,
                'fat'         => 24,
                'fiber'       => 6,
                'rating'      => 4.0,
                'ingredients' => ['Cauliflower', 'Chicken', 'Avocado', 'Olive Oil', 'Garlic'],
            ],
        ];

        foreach ($meals as $mealData) {
            $category = Category::where('name', $mealData['category'])->first();
            $ingredientNames = $mealData['ingredients'];

            unset($mealData['category'], $mealData['ingredients']);

            $meal = Meal::create(array_merge($mealData, ['category_id' => $category->id]));

            $ingredientIds = Ingredient::whereIn('name', $ingredientNames)->pluck('id');
            $meal->ingredients()->attach($ingredientIds);
        }
    }
}
