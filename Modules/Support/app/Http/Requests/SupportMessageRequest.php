<?php
namespace Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Support\app\Enums\SupportMessageTypeEnum;

class SupportMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'    => ['required', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'email'        => ['nullable', 'email', 'max:255'],
            'message_type' => ['required', Rule::in(array_column(SupportMessageTypeEnum::cases(), 'value'))],
            'message'      => ['required', 'string'],
            'image'        => ['nullable', 'image', 'max:5120'],
        ];
    }
}
