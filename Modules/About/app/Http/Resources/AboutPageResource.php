<?php

namespace Modules\About\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutPageResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'sub_title' => $this->getTranslation('sub_title', $locale),
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->getFirstMediaUrl('about_image') ? url($this->getFirstMediaUrl('about_image')) : null,
            'updated_at' => $this->updated_at,
        ];
    }
}
