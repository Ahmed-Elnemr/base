<?php

namespace Modules\Project\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Project\app\Models\ProjectRequest;
use Modules\Service\app\Models\Service;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProjectRequest::count() === 0) {
            $service = Service::first();
            ProjectRequest::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '123456789',
                'service_id' => $service?->id,
                'company' => 'John Co',
                'description' => 'I want a logo.',
                'status' => 'pending',
            ]);
        }
    }
}
