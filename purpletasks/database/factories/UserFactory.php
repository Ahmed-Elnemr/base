<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientType = fake()->randomElement([
            User::CLIENT_TYPE_CUSTOMER,
            User::CLIENT_TYPE_COMPANY,
        ]);

        return [
            'name'                => fake()->name(),
            'email'               => fake()->unique()->safeEmail(),
            'email_verified_at'   => now(),
            'password'            => static::$password ??= Hash::make('password'),
            'remember_token'      => Str::random(10),
            'client_type'         => $clientType,
            'phone'               => fake()->unique()->numerify('05########'),
            'city'                => fake()->city(),
            'company_name'        => $clientType === User::CLIENT_TYPE_COMPANY ? fake()->company() : null,
            'company_bio'         => $clientType === User::CLIENT_TYPE_COMPANY ? fake()->sentence(12) : null,
            'commercial_register' => $clientType === User::CLIENT_TYPE_COMPANY ? (string) fake()->numerify('##########') : null,
            'terms_accepted_at'   => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
