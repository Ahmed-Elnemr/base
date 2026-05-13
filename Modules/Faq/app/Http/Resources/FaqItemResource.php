<?php

namespace Modules\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'question' => $this->getTranslation('question', $locale),
            'answer' => $this->getTranslation('answer', $locale),
            'sort_order' => $this->sort_order,
        ];
    }
}



