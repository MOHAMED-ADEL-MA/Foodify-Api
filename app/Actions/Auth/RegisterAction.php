<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\OtpService;

class RegisterAction
{
    public function __construct(private OtpService $otpService) {}

    public function execute(array $data): User
    {
        // 1. إنشاء المستخدم (غير مفعّل)
        $user = User::create([
            'name'              => $data['name'],
            'phone'             => $data['phone'],
            'password'          => $data['password'],
            'is_phone_verified' => false,
        ]);

        // 2. إرسال OTP
        $this->otpService->generate($user->phone, 'register');

        return $user;
    }
}
