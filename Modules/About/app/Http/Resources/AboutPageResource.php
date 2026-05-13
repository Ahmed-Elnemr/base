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
            'intro' => $this->getTranslation('intro', $locale),
            'content' => $this->getTranslation('content', $locale),
            'image' => $this->getFirstMediaUrl('about_image'),
            'updated_at' => $this->updated_at,
        ];
    }
}










