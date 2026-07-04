<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;

interface PaymentStrategy
{
    public function pay(Order $order): array;

}
