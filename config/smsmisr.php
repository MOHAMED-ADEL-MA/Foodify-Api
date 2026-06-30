<?php

return [
    'username'    => env('SMSMISR_USERNAME'),
    'password'    => env('SMSMISR_PASSWORD'),
    'sender'      => env('SMSMISR_SENDER'),
    'environment' => env('SMSMISR_ENVIRONMENT', 2), // 1 = Live, 2 = Test
    'base_url'    => 'https://smsmisr.com/api/OTP/',

    // Templates
    'templates' => [
        'register'         => '57e397e922136ebb17480888a534825d58e19dbeea6aadfd633a8aa4ef0629ed',
        'forgot_password'  => '0ea82e58642f442b71d24dbd7bbd5fda996072704011a27bbad5c0ac058c8757',
    ],
];
