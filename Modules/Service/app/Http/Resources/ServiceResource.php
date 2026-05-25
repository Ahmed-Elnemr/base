<?php

namespace Modules\Service\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'image' => $this->getFirstMediaUrl('service_image') ? url($this->getFirstMediaUrl('service_image')) : null,
            'category' => new ServiceCategoryResource($this->whenLoaded('category')),
            'similar_services' => self::collection($this->whenLoaded('similarServices')),
            'related_works' => $this->formatRelatedWorks(),
            'created_at' => $this->created_at,
        ];
    }

    private function formatRelatedWorks(): array
    {
        $works = $this->related_works ?? [];
        $locale = app()->getLocale();

        return collect($works)->map(function ($work) use ($locale) {
            $titleKey = 'title_'.$locale;

            return [
                'image' => isset($work['image']) ? url('storage/'.$work['image']) : null,
                'title' => $work[$titleKey] ?? $work['title_en'] ?? $work['title_ar'] ?? null,
            ];
        })->toArray();
    }
}
