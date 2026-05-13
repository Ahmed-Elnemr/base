<?php

namespace Modules\ServiceFlow\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceFlowResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'step_number' => $this->step_number,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'image' => $this->getFirstMediaUrl('step_image'),
        ];
    }
}



