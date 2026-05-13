<?php

namespace Modules\Catalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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

            'price'  => 'required|numeric|min:0',
            'phone'  => 'required|string|max:20',
            'mobile' => 'required|string|max:20',

            'images'   => 'nullable|array|min:1',
            'images.*' => 'image|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            // Category
            'catalog_category_id.required' => __('catalog category is required'),
            'catalog_category_id.exists'   => __('catalog category exists'),

            // Title
            'title.required'    => __('title is required'),
            'title.array'       => __('title must be an array'),
            'title.ar.required' => __('Arabic title is required'),
            'title.en.required' => __('English title is required'),

            // Content
            'content.required'    => __('content is required'),
            'content.array'       => __('content must be an array'),
            'content.ar.required' => __('Arabic content is required'),
            'content.en.required' => __('English content is required'),

            // Features
            'features.required' => __('features are required'),
            'features.array'    => __('features must be an array'),

            // Price
            'price.required' => __('price is required'),
            'price.numeric'  => __('price must be a number'),
            'price.min'      => __('price must be greater than or equal to 0'),

            // Phone
            'phone.required' => __('phone is required'),
            'phone.string'   => __('phone must be a string'),
            'phone.max'      => __('phone must not exceed 20 characters'),

            'mobile.required' => __('mobile is required'),
            'mobile.string'   => __('mobile must be a string'),
            'mobile.max'      => __('mobile must not exceed 20 characters'),

            // Images
            'images.array'      => __('images must be an array'),
            'images.min'        => __('at least one image is required'),
            'images.*.image'    => __('each file must be an image'),
            'images.*.max'      => __('each image must not exceed 2MB'),
        ];
    }
}
