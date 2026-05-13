<?php

namespace Modules\Blog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'slug' => $this->slug,
            'thumbnail' => $this->getFirstMediaUrl('thumbnail'),
            'preview_image' => $this->getFirstMediaUrl('preview_image'),
            'keywords' => $this->getTranslation('keywords', $locale),
            'content' => $this->getTranslation('content', $locale),
            'meta_title' => $this->getTranslation('meta_title', $locale),
            'meta_description' => $this->getTranslation('meta_description', $locale),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
