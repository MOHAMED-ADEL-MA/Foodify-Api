<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentStrategy;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardPayment implements PaymentStrategy
{
    private string $secretKey;
    private string $publicKey;
    private string $integrationId;
    private string $baseUrl;

    public function __construct()
    {
        $this->secretKey     = config('paymob.secret_key');
        $this->publicKey     = config('paymob.public_key');
        $this->integrationId = config('paymob.integration_id_card');
        $this->baseUrl       = config('paymob.base_url');
    }

    public function pay(Order $order): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Token {$this->secretKey}",
                'Content-Type'  => 'application/json',
            ])->post("{$this->baseUrl}/v1/intention/", [
                'amount'          => (int) ($order->total * 100), // بالقروش
                'currency'        => 'EGP',
                'payment_methods' => [(int) $this->integrationId],
                'items'           => $this->buildItems($order),
                'billing_data'    => $this->buildBillingData($order),
                'customer'        => [
                    'first_name' => $order->user->name,
                    'last_name'  => '',
                    'email'      => 'user' . $order->user->id . '@foodify.com',
                    'extras'     => ['user_id' => $order->user_id],
                ],
                'extras'          => ['order_id' => $order->id],
            ]);

            if (! $response->successful()) {
                Log::error('Paymob Intention Error', [
                    'status'   => $response->status(),
                    'response' => $response->json(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Payment initiation failed.',
                    'data'    => [],
                ];
            }

            $body = $response->json();

            return [
                'success' => true,
                'message' => 'Payment initiated. Complete payment using the client secret.',
                'data'    => [
                    'client_secret' => $body['client_secret'],
                    'public_key'    => $this->publicKey,
                ],
            ];

        } catch (\Exception $e) {
            Log::error('Paymob Exception: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment service error.',
                'data'    => [],
            ];
        }
    }

    private function buildItems(Order $order): array
    {
        $items = $order->items->map(fn($item) => [
            'name'        => $item->meal->name,
            'amount'      => (int) ($item->price * $item->quantity * 100),
            'description' => $item->meal->name,
            'quantity'    => 1,
        ])->toArray();


        $items[] = [
            'name'        => 'Delivery Fee',
            'amount'      => (int) ($order->delivery_fee * 100),
            'description' => 'Delivery Fee',
            'quantity'    => 1,
        ];

        return $items;
    }

    private function buildBillingData(Order $order): array
    {
        return [
            'first_name'      => $order->user->name,
            'last_name'       => 'NA',
            'email'           => 'user' . $order->user->id . '@foodify.com',
            'phone_number'    => '+2' . $order->user->phone,
            'street'          => 'NA',
            'city'            => 'NA',
            'country'         => 'EG',
            'state'           => 'NA',
            'postal_code'     => 'NA',
            'building'        => 'NA',
            'floor'           => 'NA',
            'apartment'       => 'NA',
        ];
    }
}
