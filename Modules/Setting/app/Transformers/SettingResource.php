<?php

namespace Modules\Setting\Transformers;

use App\SettingTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
{
    $type = $this->type;

    return [
        'id'   => $this->id,
        'key'  => $this->key,
        'type' => $type->name,
        'value'=> $this->resolveValue(),
    ];
}

    protected function resolveValue()
{
    return match ($this->type) {

        // 🖼️ Media
        SettingTypeEnum::IMAGE,
        SettingTypeEnum::FILE,
        SettingTypeEnum::VIDEO
        => $this->getFirstMediaUrl('settings') ?: null,

        // 🌍 Translatable
        default => $this->getValue(app()->getLocale()),
    };
}
}


