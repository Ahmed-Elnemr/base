<?php

namespace Modules\Catalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithServicesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'category' => new CategoryResource($this),
            'services' => ServiceResource::collection($this->services),
        ];
    }
}








