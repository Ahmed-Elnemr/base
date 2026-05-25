<?php

namespace Modules\Service\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'service_category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'is_active',
        'sort_order',
        'related_works',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'related_works' => 'array',
    ];

    protected array $translatable = [
        'title',
        'description',
        'short_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function similarServices()
    {
        return $this->hasMany(Service::class, 'service_category_id', 'service_category_id')
            ->where('id', '!=', $this->id)
            ->active()
            ->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('service_image')
            ->useDisk('public')
            ->singleFile();
    }
}
