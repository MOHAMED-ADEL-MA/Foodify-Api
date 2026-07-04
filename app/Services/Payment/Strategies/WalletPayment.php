<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentStrategy;
use Illuminate\Support\Facades\Log;

class WalletPayment implements PaymentStrategy
{
    public function pay(Order $order): array
    {
        // Simulation Wallet pay method ( vodafon cash - fawry )
        Log::info("Wallet payment simulation for Order #{$order->id}", [
            'amount' => $order->total,
        ]);

        return [
            'success' => true,
            'message' => 'Wallet payment successful.',
            'data'    => [
                'transaction_ref' => 'WALLET-' . strtoupper(uniqid()),
            ],
        ];
    }
}
