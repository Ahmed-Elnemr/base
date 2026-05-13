<?php

namespace Modules\Catalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'category' => $this->category
                ? [
                    'id' => $this->category->id,
                    'name' => $this->category->getTranslation('name', $locale),
                ]
                : null,
            'title' => $this->getTranslation('title', $locale),
            'content' => $this->getTranslation('content', $locale),
            'price' => $this->price,
            'phone' => $this->phone,
            'features' => collect($this->features)
                ->map(fn ($feature) => is_array($feature) ? ($feature['value'] ?? null) : $feature)
                ->filter()
                ->values()
                ->toArray(),
            'gallery' => $this->getMedia('service_gallery')->map->getFullUrl()->toArray(),
        ];
    }
}

