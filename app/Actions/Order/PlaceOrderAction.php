<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\User;
use App\Services\Payment\PaymentContext;
use Illuminate\Support\Facades\DB;

class PlaceOrderAction
{
    private float $deliveryFee = 20.00;

    public function execute(User $user, string $paymentMethod): array
    {
        return DB::transaction(function () use ($user, $paymentMethod) {

            //  جيب الـ Cart items
            $cartItems = CartItem::where('user_id', $user->id)
                                    ->with('meal:id,name,price')
                                    ->get();

            //  احسب الـ Totals
            $subtotal = $cartItems->sum(fn($item) => $item->meal->price * $item->quantity);
            $total    = $subtotal + $this->deliveryFee;

            //  نسجل الـ Order
            $order = Order::create([
                'user_id'        => $user->id,
                'status'         => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'subtotal'       => $subtotal,
                'delivery_fee'   => $this->deliveryFee,
                'total'          => $total,
            ]);

            //  نسجل الـ Order Items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'meal_id'  => $item->meal_id,
                    'quantity' => $item->quantity,
                    'price'    => $item->meal->price,
                ]);
            }

            //  load العلاقات للـ Payment
            $order->load(['items.meal:id,name,price', 'user:id,name,phone']);

            //  نفّذ الـ Payment بالـ Strategy المناسبة
            $payment = (new PaymentContext($paymentMethod))->process($order);

            if (! $payment['success']) {
                throw new \Exception($payment['message']);
            }

            //  لو الدفع تم فوراً (wallet / cash) → غيّر الـ payment_status
            if (in_array($paymentMethod, ['wallet', 'card'])) {
                $order->update(['payment_status' => 'paid']);
            }

            //  امسح الـ Cart
            CartItem::where('user_id', $user->id)->delete();

            return [
                'order'   => $order->fresh(['items.meal:id,name,image']),
                'payment' => $payment,
            ];
        });
    }
}
