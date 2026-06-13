<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //    protected function prepareForValidation(): void
    //    {
    //        // هنا نقدر نعمل dd أو أي تعديل قبل ال validation
    //        if ($this->hasFile('profile_image')) {
    //            $mime = $this->file('profile_image')->getMimeType();
    //            dd($mime); // هيطبع الـ MIME type ويوقف التنفيذ
    //        }
    //    }
    public function rules(): array
    {

        $user = $this->user();

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
            'city' => ['sometimes', 'string', 'max:100'],
            'current_password' => ['sometimes', 'string', 'min:6'],
            'password' => ['sometimes', 'string', 'min:6', 'confirmed'],

            // Company specific fields (only if user is company)
            'company_name' => ['sometimes', 'required_if:client_type,'.\App\Models\User::CLIENT_TYPE_COMPANY, 'string', 'max:255'],
            'company_bio' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'commercial_register' => ['sometimes', 'nullable', 'string', 'max:100'],

            // Profile image
            'profile_image' => ['sometimes', 'bail', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            // Terms acceptance (if not already accepted)
            'terms_accepted' => ['sometimes', function ($attribute, $value, $fail) {
                if (! in_array($value, [true, false, 1, 0, '1', '0', 'true', 'false'], true)) {
                    $fail('The '.$attribute.' field must be true or false.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => __('This email is already taken.'),
            'phone.unique' => __('This phone number is already registered.'),
            'company_name.required_if' => __('Company name is required for company accounts.'),
            'profile_image.image' => __('Profile image must be a valid image file.'),
            'profile_image.mimes' => __('Profile image must be a file of type: jpeg, png, jpg, gif, webp.'),
            'profile_image.max' => __('Profile image size must not exceed 5MB.'),
            'password.confirmed' => __('Password confirmation does not match.'),
            'password.min' => __('Password must be at least 6 characters.'),
        ];
    }
}
