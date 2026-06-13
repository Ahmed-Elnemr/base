<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_type' => ['required', Rule::in([User::CLIENT_TYPE_CUSTOMER, User::CLIENT_TYPE_COMPANY])],
            'name' => [
                Rule::requiredIf(fn () => $this->input('client_type') === User::CLIENT_TYPE_CUSTOMER),
                'nullable',
                'string',
                'max:255',
            ],
            'company_name' => [
                Rule::requiredIf(fn () => $this->input('client_type') === User::CLIENT_TYPE_COMPANY),
                'nullable',
                'string',
                'max:255',
            ],
            'company_bio' => [
                Rule::requiredIf(fn () => $this->input('client_type') === User::CLIENT_TYPE_COMPANY),
                'nullable',
                'string',
            ],
            'commercial_register' => [
                Rule::requiredIf(fn () => $this->input('client_type') === User::CLIENT_TYPE_COMPANY),
                'nullable',
                'string',
                'max:255',
            ],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['sometimes', 'bail', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'terms_accepted' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_type.required' => __('validation.auth.client_type.required'),
            'client_type.in' => __('validation.auth.client_type.in'),

            'name.required' => __('validation.auth.name.required'),
            'name.string' => __('validation.auth.name.string'),
            'name.max' => __('validation.auth.name.max'),

            'company_name.required' => __('validation.auth.company_name.required'),
            'company_name.string' => __('validation.auth.company_name.string'),
            'company_name.max' => __('validation.auth.company_name.max'),

            'company_bio.required' => __('validation.auth.company_bio.required'),
            'company_bio.string' => __('validation.auth.company_bio.string'),

            'commercial_register.required' => __('validation.auth.commercial_register.required'),
            'commercial_register.string' => __('validation.auth.commercial_register.string'),
            'commercial_register.max' => __('validation.auth.commercial_register.max'),

            'phone.required' => __('validation.auth.phone.required'),
            'phone.string' => __('validation.auth.phone.string'),
            'phone.max' => __('validation.auth.phone.max'),
            'phone.unique' => __('validation.auth.phone.unique'),

            'city.required' => __('validation.auth.city.required'),
            'city.string' => __('validation.auth.city.string'),
            'city.max' => __('validation.auth.city.max'),

            'email.required' => __('validation.auth.email.required'),
            'email.string' => __('validation.auth.email.string'),
            'email.email' => __('validation.auth.email.email'),
            'email.max' => __('validation.auth.email.max'),
            'email.unique' => __('validation.auth.email.unique'),

            'password.required' => __('validation.auth.password.required'),
            'password.string' => __('validation.auth.password.string'),
            'password.min' => __('validation.auth.password.min'),
            'password.confirmed' => __('validation.auth.password.confirmed'),

            'profile_image.image' => __('validation.auth.profile_image.image'),
            'profile_image.mimes' => __('validation.auth.profile_image.mimes'),
            'profile_image.max' => __('validation.auth.profile_image.max'),

            'terms_accepted.required' => __('validation.auth.terms.required'),
            'terms_accepted.accepted' => __('validation.auth.terms.accepted'),
        ];
    }
}
