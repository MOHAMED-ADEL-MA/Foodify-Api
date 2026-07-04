<?php

return [
    'api_key'            => env('PAYMOB_API_KEY'),
    'public_key'         => env('PAYMOB_PUBLIC_KEY'),
    'secret_key'         => env('PAYMOB_SECRET_KEY'),
    'integration_id_card'=> env('PAYMOB_INTEGRATION_ID_CARD'),
    'base_url'           => env('PAYMOB_BASE_URL', 'https://accept.paymob.com'),
];
