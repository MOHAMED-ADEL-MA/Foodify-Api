<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentStrategy;

class CashOnDeliveryPayment implements PaymentStrategy
{
    public function pay(Order $order): array
    {
        //الدفع هيتم عند الاستلام
        return [
            'success' => true,
            'message' => 'Order confirmed. Pay on delivery.',
            'data'    => [],
        ];
    }
}
