<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AboutSeeder::class,
            \Modules\Home\database\seeders\HomeSeeder::class,
            \Modules\Service\database\seeders\ServiceSeeder::class,
            \Modules\Portfolio\database\seeders\PortfolioSeeder::class,
            \Modules\Setting\database\seeders\SettingSeeder::class,
            \Modules\CaseStudy\database\seeders\CaseStudySeeder::class,
            \Modules\Project\database\seeders\ProjectSeeder::class,
        ]);
    }
}
