<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Database\Factories\BlogPostFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected static function newFactory(): BlogPostFactory
    {
        return BlogPostFactory::new();
    }

    protected $fillable = [
        'title',
        'description',
        'slug',
        'keywords',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    protected array $translatable = [
        'title',
        'description',
        'keywords',
        'content',
        'meta_title',
        'meta_description',
    ];

    public function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'keywords' => 'array',
            'content' => 'array',
            'meta_title' => 'array',
            'meta_description' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->useDisk('public')
            ->singleFile();

        $this->addMediaCollection('preview_image')
            ->useDisk('public')
            ->singleFile();
    }
}
