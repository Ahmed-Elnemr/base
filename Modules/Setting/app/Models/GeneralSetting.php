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
    ];

    public $translatable = ['address'];

    protected $casts = [
        'address' => 'array',
        'social_links' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_header')->singleFile()->useDisk('public');
        $this->addMediaCollection('logo_footer')->singleFile()->useDisk('public');
        $this->addMediaCollection('logo_admin')->singleFile()->useDisk('public');
    }
}
