<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Support\app\Models\SupportPage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Support\app\Models\SupportPage>
 */
class SupportPageFactory extends Factory
{
    protected $model = SupportPage::class;

    public function definition(): array
    {
        return [
            'title' => [
                'ar' => fake()->sentence(4),
                'en' => fake()->sentence(4),
            ],
            'description' => [
                'ar' => fake()->paragraph(),
                'en' => fake()->paragraph(),
            ],
            'is_active' => true,
        ];
    }
}
