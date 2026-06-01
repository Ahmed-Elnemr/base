<?php

namespace Modules\ServiceWork\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceWorkItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'subtitle' => $this->getTranslation('subtitle', $locale),
            'content' => $this->getTranslation('content', $locale),
            'image' => $this->getFirstMediaUrl('work_image') ? url($this->getFirstMediaUrl('work_image')) : null,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
        ];
    }
}
