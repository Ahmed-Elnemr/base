<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;
use Modules\Support\app\Models\SupportMessage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Support\app\Models\SupportMessage>
 */
class SupportMessageFactory extends Factory
{
    protected $model = SupportMessage::class;

    public function definition(): array
    {
        $messageType = fake()->randomElement(array_column(SupportMessageTypeEnum::cases(), 'value'));

        return [
            'support_page_id' => null,
            'full_name' => fake()->name(),
            'phone' => fake()->optional()->numerify('05########'),
            'email' => fake()->optional()->safeEmail(),
            'message_type' => $messageType,
            'message' => fake()->paragraph(),
            'status' => SupportMessageStatusEnum::New->value,
            'locale' => fake()->randomElement(['ar', 'en']),
        ];
    }
}
