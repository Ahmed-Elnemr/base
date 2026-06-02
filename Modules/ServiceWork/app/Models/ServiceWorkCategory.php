<?php

namespace Modules\ServiceWork\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ServiceWorkCategory extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected array $translatable = [
        'name',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceWorkItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_image')
            ->useDisk('public')
            ->singleFile();
    }
}
