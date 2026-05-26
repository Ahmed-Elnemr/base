<?php

namespace Modules\Setting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class GeneralSetting extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'address',
        'email',
        'phone',
        'website',
        'social_links',
        'occasion_title',
        'occasion_content',
        'occasion_is_active',
    ];

    public $translatable = ['address', 'occasion_title', 'occasion_content'];

    protected $casts = [
        'address' => 'array',
        'social_links' => 'array',
        'occasion_title' => 'array',
        'occasion_content' => 'array',
        'occasion_is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_header')->singleFile()->useDisk('public');
        $this->addMediaCollection('logo_footer')->singleFile()->useDisk('public');
        $this->addMediaCollection('logo_admin')->singleFile()->useDisk('public');
        $this->addMediaCollection('occasion_image')->singleFile()->useDisk('public');
    }
}
