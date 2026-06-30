<?php

namespace App\Services;

use App\Models\OtpCode;
use Illuminate\Support\Facades\Log;

class OtpService
{
    private int $expiresInMinutes = 15;

    public function __construct(private SmsMisrService $smsService) {}

    /**
     * إنشاء OTP جديد وإرساله عبر SMS Misr
     */
    public function generate(string $phone, string $type): OtpCode
    {
        // احذف الـ OTPs القديمة لنفس الـ phone و type
        OtpCode::where('phone', $phone)
            ->where('type', $type)
            ->delete();

        $code = $this->generateCode();

        $otp = OtpCode::create([
            'phone'      => $phone,
            'code'       => $code,
            'type'       => $type,
            'is_used'    => false,
            'expires_at' => now()->addMinutes($this->expiresInMinutes),
        ]);

        // إرسال OTP عبر SMS Misr
        $this->smsService->sendOtp($phone, $code, $type);

        // تسجيل في الـ log وقت التطوير
        Log::info("OTP generated [{$type}] for {$phone}: {$code}");

        return $otp;
    }

    /**
     * التحقق من صحة الكود
     */
    public function verify(string $phone, string $code, string $type): bool
    {
        $otp = OtpCode::where('phone', $phone)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->first();

        if (! $otp || ! $otp->isValid()) {
            return false;
        }

        $otp->update(['is_used' => true]);

        return true;
    }

    /**
     * توليد كود عشوائي من 4 أرقام
     */
    private function generateCode(): string
    {
        return str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}
