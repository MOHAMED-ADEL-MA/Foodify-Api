<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|exists:users,phone',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Phone number is required',
            'phone.exists'   => 'Phone number not found',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse('Validation failed', 422, $validator->errors())
        );
    }
}
