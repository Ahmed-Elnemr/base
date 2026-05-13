<?php

namespace Modules\Blog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostListResource extends JsonResource
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
        ];
    }
}
