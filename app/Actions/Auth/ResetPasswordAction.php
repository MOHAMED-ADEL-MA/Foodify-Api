<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;

class ResetPasswordAction
{
    public function __construct(private OtpService $otpService) {}

    public function execute(string $phone, string $code, string $password): array
    {
        // OTP تحقق من الـ
        $verified = $this->otpService->verify($phone, $code, 'forgot_password');

        if (! $verified) {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP',
            ];
        }


        User::where('phone', $phone)->update([
            'password' => Hash::make($password),
        ]);

        return ['success' => true];
    }
}
