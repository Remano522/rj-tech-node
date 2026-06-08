<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->user()?->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The admin username is required.',
            'name.unique' => 'This username is already in use.',
        ];
    }
}
