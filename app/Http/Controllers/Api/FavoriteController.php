<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponseTrait;


    // كل الوجبات المحفوظة

    public function index(Request $request): JsonResponse
    {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with('meal:id,name,image,price,calories,protein,rating')
            ->get()
            ->pluck('meal');

        if($favorites->isEmpty())
            return $this->successResponse(message:'Favorite list is empty');

        return $this->successResponse($favorites);
    }

    // إضافة وجبة للـ Favorites

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
        ]);

        $already = Favorite::where('user_id', $request->user()->id)
                            ->where('meal_id', $request->meal_id)
                            ->exists();

        if ($already) {
            return $this->errorResponse('Meal already in favorites.', 422);
        }

        Favorite::create([
            'user_id' => $request->user()->id,
            'meal_id' => $request->meal_id,
        ]);

        return $this->successResponse(null, 'Meal added to favorites.', 201);
    }


    // حذف وجبة من الـ Favorites

    public function remove(Request $request, int $mealId): JsonResponse
    {
        $deleted = Favorite::where('user_id', $request->user()->id)
                            ->where('meal_id', $mealId)
                            ->delete();

        if (! $deleted) {
            return $this->errorResponse('Meal not found in favorites.', 404);
        }

        return $this->successResponse(message: 'Meal removed from favorites.');
    }
}
