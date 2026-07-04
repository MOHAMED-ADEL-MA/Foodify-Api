<?php

namespace App\Http\Requests\Profile;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string|max:100',
            'profile_image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'              => 'Name must be a string',
            'name.max'                 => 'Name must not exceed 100 characters',
            'profile_image.image'      => 'File must be an image',
            'profile_image.mimes'      => 'Image must be jpg, jpeg, or png',
            'profile_image.max'        => 'Image size must not exceed 2MB',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse('Validation failed', 422, $validator->errors())
        );
    }
}
