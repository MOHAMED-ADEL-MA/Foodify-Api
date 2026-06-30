<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\VerifyOtpAction;
use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\ResetPasswordAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    // ─────────────────────────────────────────
    // POST /api/auth/register
    // ─────────────────────────────────────────
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $user = $action->execute($request->validated());

        return $this->successResponse(
            ['user' => $user],
            'Account created successfully. OTP sent to your phone.',
            201
        );
    }

    // ─────────────────────────────────────────
    // POST /api/auth/verify-otp
    // ─────────────────────────────────────────
    public function verifyOtp(VerifyOtpRequest $request, VerifyOtpAction $action): JsonResponse
    {
        $data   = $request->validated();
        $result = $action->execute($data['phone'], $data['code'], $data['type']);

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 422);
        }

        if ($data['type'] === 'register') {
            return $this->successResponse(
                [
                    'user'  => $result['user'],
                    'token' => $result['token'],
                ],
                'Phone verified successfully.'
            );
        }

        return $this->successResponse(null, 'OTP verified. You can now reset your password.');
    }

    // ─────────────────────────────────────────
    // POST /api/auth/login
    // ─────────────────────────────────────────
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $data   = $request->validated();
        $result = $action->execute($data['phone'], $data['password']);

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 401);
        }

        return $this->successResponse(
            [
                'user'  => $result['user'],
                'token' => $result['token'],
            ],
            'Logged in successfully.'
        );
    }

    // ─────────────────────────────────────────
    // POST /api/auth/forgot-password
    // ─────────────────────────────────────────
    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordAction $action): JsonResponse
    {
        $action->execute($request->validated()['phone']);

        return $this->successResponse(null, 'OTP sent to your phone.');
    }

    // ─────────────────────────────────────────
    // POST /api/auth/reset-password
    // ─────────────────────────────────────────
    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action): JsonResponse
    {
        $data   = $request->validated();
        $result = $action->execute($data['phone'], $data['code'], $data['password']);

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 422);
        }

        return $this->successResponse(null, 'Password reset successfully.');
    }

    // ─────────────────────────────────────────
    // POST /api/auth/logout
    // ─────────────────────────────────────────
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logged out successfully.');
    }

    // ─────────────────────────────────────────
    // GET /api/auth/me
    // ─────────────────────────────────────────
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse($request->user());
    }
}
