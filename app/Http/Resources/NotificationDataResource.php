<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => (string) ($this['title'][app()->getLocale()] ?? $this['title']['ar'] ?? $this['title']['en'] ?? ''),
            'message' => (string) ($this['body'][app()->getLocale()] ?? $this['body']['ar'] ?? $this['body']['en'] ?? ''),
            'type' => @$this['type'] ?? '',
            'model_id' => (int) @$this['model_id'],
        ];
    }
}
