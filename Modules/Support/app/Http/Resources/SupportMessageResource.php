<?php
namespace Modules\Support\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        $type   = $this->message_type;
        $status = $this->status;

        return [
            'id'           => $this->id,
            'full_name'    => $this->full_name,
            'phone'        => $this->phone,
            'email'        => $this->email,
            'message_type' => $type instanceof \BackedEnum  ? $type->value : $type,
            'message'      => $this->message,
            'status'       => $status instanceof \BackedEnum  ? $status->value : $status,
            'image_url'    => method_exists($this->resource, 'getFirstMediaUrl')
                ? $this->getFirstMediaUrl('support_message_image')
                : null,
            'created_at'   => $this->created_at,
        ];
    }
}
