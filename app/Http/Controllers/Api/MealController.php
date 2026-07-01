<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Meal;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealController extends Controller
{
    use ApiResponseTrait;

    // كل الـ Categories
    public function categories(): JsonResponse
    {
        $categories = Category::select('id', 'name', 'image')->get();

        return $this->successResponse($categories);
    }


    // قائمة الوجبات مع فلترة اختيارية

    public function index(Request $request): JsonResponse
    {
        $meals = Meal::query()
            ->select('id', 'category_id', 'name', 'image', 'price', 'calories', 'protein', 'rating')
            ->with('category:id,name')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->get();

        return $this->successResponse($meals);
    }

    // تفاصيل وجبة واحدة
    public function show(Meal $meal): JsonResponse
    {
        $meal->load([
            'category:id,name',
            'ingredients:id,name,icon',
        ]);

        return $this->successResponse($meal);
    }
}
