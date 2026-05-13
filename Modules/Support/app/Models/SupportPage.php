<?php

namespace Modules\Support\app\Models;

use Database\Factories\SupportPageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class SupportPage extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected static function newFactory(): Factory
    {
        return SupportPageFactory::new();
    }

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'title',
        'description',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('support_image')
            ->useDisk('public')
            ->singleFile();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class, 'support_page_id')->latest();
    }
}
