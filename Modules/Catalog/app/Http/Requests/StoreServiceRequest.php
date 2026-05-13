<?php

namespace Modules\Catalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locale = app()->getLocale();
        return [
            'catalog_category_id' => 'required|exists:catalog_categories,id',

            'title'    => 'required|array',
            "title.{$locale}" => 'required|string|max:255',
            "title.ar" => 'nullable|string|max:255',
            "title.en" => 'nullable|string|max:255',

            'content'    => 'required|array',
            "content.{$locale}" => 'required|string|max:1255',
            "content.ar" => 'nullable|string|max:1255',
            "content.en" => 'nullable|string|max:1255',

            'features' => 'required|array',

            'price'      => 'required|numeric|min:0',
            'phone'      => 'required|string|max:20',
            'mobile'     =>'required|string|max:20',

            'images'   => 'required|array|min:1',
            'images.*' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            // Category
            'catalog_category_id.required' => __('Catalog category is required'),
            'catalog_category_id.exists'   => __('Selected catalog category does not exist'),

            // Title
            'title.required'    => __('Title is required'),
            'title.array'       => __('Title must be an array'),
            'title.ar.required' => __('Arabic title is required'),
            'title.en.required' => __('English title is required'),

            // Content & Features
            'content.required'  => __('Content is required'),
            'content.array'     => __('Content must be an array'),
            'content.ar.required' => __('Arabic content is required'),
            'content.en.required' => __('English content is required'),

            'features.required' => __('Features are required'),
            'features.array'    => __('Features must be an array'),

            // Price
            'price.required' => __('Price is required'),
            'price.numeric'  => __('Price must be a number'),
            'price.min'      => __('Price must be greater than zero'),

            // Phone
            'phone.required' => __('Phone number is required'),
            'phone.string'   => __('Phone number must be a string'),
            'phone.max'      => __('Phone number must not exceed 20 characters'),
            'mobile.required' => __('Mobile number is required'),
            'mobile.string'   => __('Mobile number must be a string'),
            'mobile.max'      => __('Mobile number must not exceed 20 characters'),
            // Images
            'images.required'   => __('Images are required'),
            'images.array'      => __('Images must be an array'),
            'images.min'        => __('At least one image is required'),
            'images.*.required' => __('Image file is required'),
            'images.*.image'    => __('Each file must be an image'),
            'images.*.max'      => __('Each image must not exceed 2MB'),
        ];
    }
}
