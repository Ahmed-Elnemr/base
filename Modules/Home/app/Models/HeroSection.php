<?php

namespace Modules\Home\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HeroSection extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text_1',
        'button_text_2',
        'button_url_1',
        'button_url_2',
    ];

    public $translatable = ['title', 'subtitle', 'button_text_1', 'button_text_2'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')
            ->useDisk('public');
    }
}
