<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:100',
            'phone'                 => 'required|string|unique:users,phone',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                  => 'Name is required',
            'phone.required'                 => 'Phone number is required',
            'phone.unique'                   => 'Phone number already registered',
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
