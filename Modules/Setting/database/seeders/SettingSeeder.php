<?php

namespace Modules\Setting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\app\Models\Setting;
use App\SettingTypeEnum;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Setting::count() === 0) {
            Setting::create([
                'name' => ['en' => 'Site Name', 'ar' => 'اسم الموقع'],
                'key' => 'site_name',
                'value' => ['en' => 'Purple Agency', 'ar' => 'وكالة الأرجواني'],
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => true,
            ]);

            Setting::create([
                'name' => ['en' => 'Contact Email', 'ar' => 'البريد الإلكتروني للتواصل'],
                'key' => 'contact_email',
                'value' => 'info@purple.com',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => false,
            ]);

            Setting::create([
                'name' => ['en' => 'Phone Number', 'ar' => 'رقم الهاتف'],
                'key' => 'phone_number',
                'value' => '+963 11 222 3333',
                'type' => SettingTypeEnum::SHORT_TEXT,
                'is_translatable' => false,
            ]);
        }

        if (\Modules\Setting\app\Models\GeneralSetting::count() === 0) {
            \Modules\Setting\app\Models\GeneralSetting::create([
                'address' => [
                    'en' => 'Damascus, Syria',
                    'ar' => 'دمشق، سوريا',
                ],
                'email' => 'info@purpleartagency.net',
                'phone' => '+963 11 222 3333',
                'website' => 'purpleartagency.net',
                'social_links' => [
                    ['platform' => 'facebook', 'url' => '#'],
                    ['platform' => 'instagram', 'url' => '#'],
                ],
            ]);
        }
    }
}
