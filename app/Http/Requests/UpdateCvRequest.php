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
            'bio.min' => 'Bio minimal 30 karakter agar profil lebih jelas.',
            'photo.max' => 'Ukuran foto creator maksimal 2MB.',
        ];
    }
}
