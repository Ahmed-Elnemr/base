<?php
namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'       => ['required', 'string', 'max:20'],
            'password'    => ['required', 'string'],
            'client_type' => ['required', Rule::in([User::CLIENT_TYPE_CUSTOMER, User::CLIENT_TYPE_COMPANY])],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required'       => __('validation.auth.phone.required'),
            'phone.string'         => __('validation.auth.phone.string'),
            'phone.max'            => __('validation.auth.phone.max'),

            'password.required'    => __('validation.auth.password.required'),
            'password.string'      => __('validation.auth.password.string'),

            'client_type.required' => __('validation.auth.client_type.required'),
            'client_type.in'       => __('validation.auth.client_type.in'),
        ];
    }
}
