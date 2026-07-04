<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentStrategy;
use App\Services\Payment\Strategies\CardPayment;
use App\Services\Payment\Strategies\WalletPayment;
use App\Services\Payment\Strategies\CashOnDeliveryPayment;
use InvalidArgumentException;

class PaymentContext
{
    private PaymentStrategy $strategy;

    public function __construct(string $paymentMethod)
    {
        $this->strategy = match ($paymentMethod) {
            'card'             => new CardPayment(),
            'wallet'           => new WalletPayment(),
            'cash_on_delivery' => new CashOnDeliveryPayment(),
            default            => throw new InvalidArgumentException("Unsupported payment method: {$paymentMethod}"),
        };
    }

    public function process(Order $order): array
    {
        return $this->strategy->pay($order);
    }
}
