<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Actions\Profile\UpdateProfileAction;
use App\Actions\Profile\ChangePasswordAction;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponseTrait;


    //  show Profile details

    public function show(Request $request): JsonResponse
    {
        return $this->successResponse($request->user());
    }

    //  update user name ,image

    public function update(UpdateProfileRequest $request, UpdateProfileAction $action): JsonResponse
    {
        $data = $request->validated();

        if($request->hasFile('profile_image')){
            $data['profile_image'] = $request->file('profile_image');
        }

        $user = $action->execute($request->user(), $data);

        return $this->successResponse($user, 'Profile updated successfully.');
    }

    //  change password

    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $action): JsonResponse
    {
        $result = $action->execute(
            $request->user(),
            $request->current_password,
            $request->password
        );

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 422);
        }

        return $this->successResponse(null, 'Password changed successfully. Please login again.');
    }

    //  user's orders list

    public function orders(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.meal:id,name,image')
            ->latest()
            ->get();

        return $this->successResponse($orders);
    }
}
