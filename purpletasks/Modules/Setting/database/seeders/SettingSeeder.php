<?php

namespace Modules\Setting\database\seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
