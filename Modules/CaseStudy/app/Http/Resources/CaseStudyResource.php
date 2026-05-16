<?php

namespace Modules\CaseStudy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseStudyResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'slug' => $this->slug,
            'image' => $this->getFirstMediaUrl('case_study_image') ? url($this->getFirstMediaUrl('case_study_image')) : null,
            'created_at' => $this->created_at,
        ];
    }
}
