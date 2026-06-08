<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'The current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password confirmation does not match.',
            'password.different' => 'The new password must be different from the current password.',
        ];
    }
}
