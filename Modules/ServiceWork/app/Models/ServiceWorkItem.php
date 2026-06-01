<?php

namespace Modules\ServiceWork\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ServiceWorkItem extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'service_work_category_id',
        'title',
        'subtitle',
        'content',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'content' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'service_work_category_id' => 'integer',
    ];

    protected array $translatable = [
        'title',
        'subtitle',
        'content',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceWorkCategory::class, 'service_work_category_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('work_image')
            ->useDisk('public')
            ->singleFile();
    }
}
