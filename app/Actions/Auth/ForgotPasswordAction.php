<?php

namespace App\Actions\Auth;

use App\Services\OtpService;

class ForgotPasswordAction
{
    public function __construct(private OtpService $otpService) {}

    public function execute(string $phone): void
    {
        $this->otpService->generate($phone, 'forgot_password');
    }
}
