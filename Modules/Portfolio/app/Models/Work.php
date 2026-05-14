<?php

namespace Modules\Portfolio\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Work extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected array $translatable = [
        'title',
        'subtitle',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('work_thumbnail')
            ->useDisk('public')
            ->singleFile();

        $this->addMediaCollection('work_file')
            ->useDisk('public')
            ->singleFile();
    }
}
