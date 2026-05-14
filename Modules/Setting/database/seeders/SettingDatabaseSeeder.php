<?php

namespace Modules\Setting\database\seeders;

use App\SettingTypeEnum;
use Illuminate\Database\Seeder;
use Modules\Setting\app\Models\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing settings
        Setting::truncate();

        $settings = [
            [
                'name' => ['en' => 'Site Name', 'ar' => 'اسم الموقع'],
                'key' => 'site_name',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => true,
            ],
            [
                'name' => ['en' => 'Site Description', 'ar' => 'وصف الموقع'],
                'key' => 'site_description',
                'type' => SettingTypeEnum::LONG_TEXT,
                'is_translatable' => true,
            ],
            [
                'name' => ['en' => 'Site Email', 'ar' => 'البريد الإلكتروني للموقع'],
                'key' => 'site_email',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Site Phone', 'ar' => 'رقم هاتف الموقع'],
                'key' => 'site_phone',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'LinkedIn Link', 'ar' => 'رابط لينكد إن'],
                'key' => 'social_linkedin',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'WhatsApp Number', 'ar' => 'رقم الواتساب'],
                'key' => 'social_whatsapp',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Arabic Logo', 'ar' => 'اللوجو العربي'],
                'key' => 'logo_ar',
                'type' => SettingTypeEnum::IMAGE,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'English Logo', 'ar' => 'اللوجو الإنجليزي'],
                'key' => 'logo_en',
                'type' => SettingTypeEnum::IMAGE,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Privacy Policy', 'ar' => 'سياسة الخصوصية'],
                'key' => 'privacy_policy',
                'type' => SettingTypeEnum::RICH_TEXT,
                'is_translatable' => true,
            ],
            [
                'name' => ['en' => 'Terms and Conditions', 'ar' => 'الشروط والأحكام'],
                'key' => 'terms_conditions',
                'type' => SettingTypeEnum::RICH_TEXT,
                'is_translatable' => true,
            ],
            [
                'name' => ['en' => 'Facebook Link', 'ar' => 'رابط فيسبوك'],
                'key' => 'social_facebook',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Twitter (X) Link', 'ar' => 'رابط تويتر'],
                'key' => 'social_twitter',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Instagram Link', 'ar' => 'رابط انستجرام'],
                'key' => 'social_instagram',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'Snapchat Link', 'ar' => 'رابط سناب شات'],
                'key' => 'social_snapchat',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
            [
                'name' => ['en' => 'TikTok Link', 'ar' => 'رابط تيك توك'],
                'key' => 'social_tiktok',
                'type' => SettingTypeEnum::URL,
                'is_translatable' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
