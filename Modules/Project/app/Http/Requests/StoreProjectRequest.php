<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service_id' => 'nullable|exists:services,id',
            'company' => 'nullable|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __('The :attribute field is required.'),
            'email' => __('The :attribute must be a valid email address.'),
            'max' => __('The :attribute may not be greater than :max characters.'),
            'exists' => __('The selected :attribute is invalid.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'email' => __('Email'),
            'phone' => __('Phone'),
            'service_id' => __('Service'),
            'description' => __('Description'),
            'company' => __('Company'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
