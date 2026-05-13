<?php

namespace Modules\Catalog\app\Models;

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

    protected $table = 'catalog_services';

    protected $fillable = [
        'catalog_category_id',
        'user_id',
        'title',
        'content',
        'price',
        'phone',
        'mobile',
        'features',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'features' => 'array',
        'price' => 'decimal:2',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'title',
        'content',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'catalog_category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('service_gallery')->useDisk('public');
    }
}

