<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyOtpRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string',
            'code'  => 'required|string|size:4',
            'type'  => 'required|in:register,forgot_password',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Phone number is required',
            'code.required'  => 'OTP code is required',
            'code.size'      => 'OTP code must be 4 digits',
            'type.required'  => 'Type is required',
            'type.in'        => 'Type must be register or forgot_password',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse('Validation failed', 422, $validator->errors())
        );
    }
}
