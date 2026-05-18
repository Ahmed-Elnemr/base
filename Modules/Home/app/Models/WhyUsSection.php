<?php

namespace Modules\Home\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class WhyUsSection extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'points',
    ];

    public $translatable = ['title', 'content', 'points'];

    protected $casts = [
        'points' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('why_us_image')
            ->useDisk('public')
            ->singleFile();
    }
}
