<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Actions\Order\PlaceOrderAction;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponseTrait;

    // إنشاء أوردر جديد من الـ Cart
    public function store(Request $request, PlaceOrderAction $action): JsonResponse
    {
        $request->validate([
            'payment_method' => 'required|in:card,vodafone_cash,fawry,cash_on_delivery',
        ]);

        if ($request->user()->cartItems()->count() === 0) {
            return $this->errorResponse('Your cart is empty.', 422);
        }

        try {
            $result = $action->execute($request->user(), $request->payment_method);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }

        return $this->successResponse([
            'order'   => $result['order'],
            'payment' => $result['payment'],
        ], 'Order placed successfully.', 201);
    }


    // كل أوردرات المستخدم
    public function index(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.meal:id,name,image')
            ->latest()
            ->get();

        return $this->successResponse($orders);
    }


    // تفاصيل أوردر واحد

    public function show(Request $request, Order $order): JsonResponse
    {

        if ($order->user_id !== $request->user()->id) {
            return $this->errorResponse('Order not found.', 404);
        }

        $order->load('items.meal:id,name,image');

        return $this->successResponse($order);
    }
}
