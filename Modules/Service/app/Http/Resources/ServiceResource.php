<?php

namespace Modules\Service\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Portfolio\Http\Resources\WorkResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'slug' => $this->slug,
            'short_description' => $this->getTranslation('short_description', $locale),
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->getFirstMediaUrl('service_image'),
            'steps_image' => $this->getFirstMediaUrl('steps_image'),
            'stats' => $this->stats,
            'features' => $this->features,
            'steps' => $this->steps,
            'faqs' => $this->faqs,
            'category' => new ServiceCategoryResource($this->whenLoaded('category')),
            'related_works' => WorkResource::collection($this->whenLoaded('relatedWorks')),
            'created_at' => $this->created_at,
        ];
    }
}
