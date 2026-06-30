<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsMisrService
{
    private string $username;
    private string $password;
    private string $sender;
    private int    $environment;
    private string $baseUrl;
    private array  $templates;

    public function __construct()
    {
        $this->username    = config('smsmisr.username');
        $this->password    = config('smsmisr.password');
        $this->sender      = config('smsmisr.sender');
        $this->environment = config('smsmisr.environment');
        $this->baseUrl     = config('smsmisr.base_url');
        $this->templates   = config('smsmisr.templates');
    }

    /**
     * إرسال OTP عبر SMS Misr OTP API
     *
     * @param string $phone رقم الموبايل (بيتحول تلقائيًا لصيغة 201XXXXXXXXX)
     * @param string $code  الكود المراد إرساله
     * @param string $type  نوع الـ OTP (register / forgot_password)
     */
    public function sendOtp(string $phone, string $code, string $type): bool
    {
        $template = $this->templates[$type] ?? $this->templates['register'];

        try {
            $response = Http::post($this->baseUrl, [
                'environment' => $this->environment,
                'username'    => $this->username,
                'password'    => $this->password,
                'sender'      => $this->sender,
                'mobile'      => $this->formatPhone($phone),
                'template'    => $template,
                'otp'         => $code,
            ]);

            $body = $response->json();
            $code_response = $body['Code'] ?? null;

            if ($code_response === '4901') {
                Log::info("✅ OTP sent via SMS Misr", [
                    'phone'  => $phone,
                    'smsid'  => $body['SMSID'] ?? null,
                    'cost'   => $body['Cost'] ?? null,
                ]);
                return true;
            }

            Log::error("❌ SMS Misr error", [
                'phone'    => $phone,
                'code'     => $code_response,
                'response' => $body,
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error("❌ SMS Misr exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحويل الرقم المصري لصيغة SMS Misr (201XXXXXXXXX)
     * مثال: 01012345678 → 201012345678
     */
    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '20' . substr($phone, 1);
        }

        return $phone;
    }
}
