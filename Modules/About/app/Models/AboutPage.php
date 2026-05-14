<?php
namespace Modules\About\app\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class AboutPage extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'sub_title',
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'sub_title'   => 'array',
        'title'       => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
    ];

    protected array $translatable = [
        'sub_title',
        'title',
        'description',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('about_image')
            ->useDisk('public')
            ->singleFile();
    }
}









