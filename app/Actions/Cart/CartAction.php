<?php

namespace App\Actions\Cart;

use App\Models\CartItem;
use App\Models\User;

class CartAction
{

    // Cart إضافة وجبة للـ

    public function add(User $user, int $mealId, int $quantity = 1): CartItem
    {
        $item = CartItem::where('user_id', $user->id)
            ->where('meal_id', $mealId)
            ->first();

        if ($item) {                                 // لو موجودة → يزود الكمية
            $item->increment('quantity', $quantity);
            return $item->fresh();
        }

        return CartItem::create([
            'user_id'  => $user->id,
            'meal_id'  => $mealId,
            'quantity' => $quantity,
        ]);
    }

    // تعديل الكمية مباشرة

    public function update(User $user, int $mealId, int $quantity): CartItem|false
    {
        $item = CartItem::where('user_id', $user->id)
            ->where('meal_id', $mealId)
            ->first();

        if (! $item) {
            return false;
        }

        $item->update(['quantity' => $quantity]);
        return $item->fresh();
    }

    // حذف وجبة من الـ Cart
    public function remove(User $user, int $mealId): bool
    {
        return (bool) CartItem::where('user_id', $user->id)
            ->where('meal_id', $mealId)
            ->delete();
    }

    // مسح الـ Cart بالكامل
    public function clear(User $user): void
    {
        CartItem::where('user_id', $user->id)->delete();
    }
}
