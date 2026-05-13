<?php

namespace Modules\Catalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        $firstImage = $this->getFirstMediaUrl('service_gallery');
        $featurePreview = collect($this->features)
            ->map(fn ($feature) => is_array($feature) ? ($feature['value'] ?? null) : $feature)
            ->filter()
            ->values();

        return [
            'id' => $this->id,
            'category' => $this->category
                ?  $this->category->name
                : null,
            'title' => $this->getTranslation('title', $locale),
            'content' => $this->getTranslation('content', $locale),
            'price' => $this->price,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'feature_preview' => $featurePreview,
            'image' => $firstImage,
        ];
    }
}

