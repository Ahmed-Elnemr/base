<?php

namespace Modules\Setting\app\Models;

use App\SettingTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

// use Modules\Setting\Database\Factories\SettingFactory;

class Setting extends Model implements HasMedia
{
    use HasFactory,HasRoles ,HasTranslations,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'key',
        'value',
        'type',
        'is_translatable',
    ];

    public $translatable = ['name'];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'type' => SettingTypeEnum::class,
        'is_translatable' => 'boolean',
        'value' => 'array',
    ];


    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('settings')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'image/svg+xml',
                'application/pdf',
                'video/mp4',
                'video/webm',
            ]);
    }

    /**
     * Get value for specific locale.
     */
    public function getValue($locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        if ($this->is_translatable) {
            $values = $this->value ?? [];
            return $values[$locale] ?? $values['en'] ?? null;
        }

        return $this->value;
    }

    /**
     * Set value for specific locale.
     */
    public function setValue($value, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        if ($this->is_translatable) {
            $values = $this->value ?? [];
            $values[$locale] = $value;
            $this->value = $values;
        } else {
            $this->value = $value;
        }
    }
}
