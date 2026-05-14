<?php

namespace Modules\Portfolio\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'subtitle' => $this->getTranslation('subtitle', $locale),
            'type' => $this->type,
            'thumbnail' => $this->getFirstMediaUrl('work_thumbnail'),
            'file' => $this->type === 'video' ? $this->getFirstMediaUrl('work_file') : null,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
        ];
    }
}
