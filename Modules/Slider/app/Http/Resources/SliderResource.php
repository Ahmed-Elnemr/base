<?php

namespace Modules\Slider\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->getFirstMediaUrl('slider_cover'),
            'published_at' => $this->published_at,
            'sort_order' => $this->sort_order,
        ];
    }
}










