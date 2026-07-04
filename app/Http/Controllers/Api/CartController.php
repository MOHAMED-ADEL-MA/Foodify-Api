<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Actions\Cart\CartAction;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;

    private float $deliveryFee = 20.00;


    public function index(Request $request): JsonResponse
    {
        $items = CartItem::where('user_id', $request->user()->id)
            ->with('meal:id,name,image,price')
            ->get()
            ->map(fn($item) => [
                'id'        => $item->id,
                'meal'      => $item->meal,
                'quantity'  => $item->quantity,
                'subtotal'  => round($item->meal->price * $item->quantity, 2),
            ]);

            if ($items->isEmpty())
                return $this->successResponse($items,'Your Cart is empty');

        $subtotal = $items->sum('subtotal');
        $total    = $subtotal + ($items->isEmpty() ? 0 : $this->deliveryFee);

        return $this->successResponse([
            'items'        => $items,
            'subtotal'     => $subtotal,
            'delivery_fee' => $items->isEmpty() ? 0 : $this->deliveryFee,
            'total'        => $total,
        ]);
    }


    public function add(Request $request, CartAction $action): JsonResponse
    {
        $request->validate([
            'meal_id'  => 'required|exists:meals,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $item = $action->add(
            $request->user(),
            $request->meal_id,
            $request->quantity ?? 1
        );

        return $this->successResponse($item, 'Item added to cart.', 201);
    }


    public function update(Request $request, int $mealId, CartAction $action): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = $action->update($request->user(), $mealId, $request->quantity);

        if (! $item) {
            return $this->errorResponse('Item not found in cart.', 404);
        }

        return $this->successResponse($item, 'Cart updated.');
    }


    public function remove(Request $request, int $mealId, CartAction $action): JsonResponse
    {
        $removed = $action->remove($request->user(), $mealId);

        if (! $removed) {
            return $this->errorResponse('Item not found in cart.', 404);
        }

        return $this->successResponse(null, 'Item removed from cart.');
    }


    public function clear(Request $request, CartAction $action): JsonResponse
    {
        $action->clear($request->user());

        return $this->successResponse(null, 'Cart cleared.');
    }
}
