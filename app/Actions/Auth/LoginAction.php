<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function execute(string $phone, string $password): array
    {
        $user = User::where('phone', $phone)->first();

        // 1. تحقق من وجود المستخدم وصحة الباسورد
        if (! $user || ! Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid phone or password',
            ];
        }

        // 2. تحقق إن التليفون اتأكد
        if (! $user->is_phone_verified) {
            return [
                'success' => false,
                'message' => 'Phone number not verified. Please verify your OTP first',
            ];
        }

        // 3. احذف الـ tokens القديمة وأنشئ جديد
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'user'    => $user,
            'token'   => $token,
        ];
    }
}
