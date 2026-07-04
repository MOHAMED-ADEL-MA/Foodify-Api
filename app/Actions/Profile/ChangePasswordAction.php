<?php

namespace App\Actions\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function execute(User $user, string $currentPassword, string $newPassword): array
    {
        // تحقق من الباسورد الحالي
        if (! Hash::check($currentPassword, $user->password)) {
            return [
                'success' => false,
                'message' => 'Current password is incorrect',
            ];
        }

        $user->update(['password' => $newPassword]);

        // احذف كل الـ tokens القديمة (forced logout من كل الأجهزة)
        $user->tokens()->delete();

        return ['success' => true];
    }
}
