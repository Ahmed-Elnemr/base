<?php

namespace Modules\Setting\app\Helpers;

use Modules\Setting\app\Models\Setting;
use App\Enums\SettingTypeEnum;

class SettingHelper
{
    public static function get(string $key, $default = null, $locale = null)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        $locale = $locale ?: app()->getLocale();

        switch ($setting->type) {
            case SettingTypeEnum::BOOLEAN:
                return (bool) $setting->getValue($locale);

            case SettingTypeEnum::INTEGER:
                return (int) $setting->getValue($locale);

            case SettingTypeEnum::DECIMAL:
                return (float) $setting->getValue($locale);

            case SettingTypeEnum::IMAGE:
            case SettingTypeEnum::FILE:
            case SettingTypeEnum::VIDEO:
                return $setting->getFirstMediaUrl('settings');

            case SettingTypeEnum::SELECT:
                $options = json_decode($setting->getValue($locale), true) ?? [];
                return $options[$setting->selected_value] ?? $default;

            default:
                return $setting->getValue($locale) ?? $default;
        }
    }

    public static function set(string $key, $value, string $type = null, bool $isTranslatable = false): Setting
    {
        $setting = Setting::firstOrNew(['key' => $key]);

        if ($type) {
            $setting->type = $type;
        }

        $setting->is_translatable = $isTranslatable;

        if ($isTranslatable && is_array($value)) {
            $setting->value = $value;
        } else {
            $setting->value = $value;
        }

        $setting->save();

        return $setting;
    }
}
