<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('validation.auth.email.required'),
            'email.string' => __('validation.auth.email.string'),
            'email.email' => __('validation.auth.email.email'),

            'password.required' => __('validation.auth.password.required'),
            'password.string' => __('validation.auth.password.string'),
        ];
    }
}
