<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'                 => 'required|string|exists:users,phone',
            'code'                  => 'required|string|size:4',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required'                 => 'Phone number is required',
            'phone.exists'                   => 'Phone number not found',
            'code.required'                  => 'OTP code is required',
            'code.size'                      => 'OTP code must be 4 digits',
            'password.required'              => 'Password is required',
            'password.min'                   => 'Password must be at least 8 characters',
            'password.confirmed'             => 'Passwords do not match',
            'password_confirmation.required' => 'Password confirmation is required',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse('Validation failed', 422, $validator->errors())
        );
    }
}
