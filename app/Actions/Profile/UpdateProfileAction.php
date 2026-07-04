<?php

namespace App\Actions\Profile;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfileAction
{
    public function execute(User $user, array $data): User
    {
        // لو فيه صورة جديدة
        if (isset($data['profile_image']) && $data['profile_image'] instanceof UploadedFile) {
            // احذف القديمة لو موجودة
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // احفظ الجديدة
            $path = $data['profile_image']->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return $user->fresh();
    }
}
