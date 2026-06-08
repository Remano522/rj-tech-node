<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'min:30'],
            'education' => ['required', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
            'experience' => ['nullable', 'string'],
            'certifications' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'remove_photo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'bio.min' => 'The bio must be at least 30 characters long.',
            'photo.max' => 'The creator photo must not exceed 2MB.',
        ];
    }
}
