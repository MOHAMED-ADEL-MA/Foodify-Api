<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\OtpService;

class VerifyOtpAction
{
    public function __construct(private OtpService $otpService) {}

    public function execute(string $phone, string $code, string $type): array
    {
        // 1. تحقق من الكود
        $verified = $this->otpService->verify($phone, $code, $type);

        if (! $verified) {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP',
            ];
        }

        // 2. لو نوعه register → فعّل الحساب وأرجع token
        if ($type === 'register') {
            $user = User::where('phone', $phone)->firstOrFail();

            $user->update([
                'is_phone_verified' => true,
                'phone_verified_at' => now(),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'success' => true,
                'user'    => $user,
                'token'   => $token,
            ];
        }

        // 3. لو نوعه forgot_password → بس confirm إن الـ OTP صح
        return ['success' => true];
    }
}
