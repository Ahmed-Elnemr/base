<?php

namespace Modules\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqSectionResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
        ];
    }
}

