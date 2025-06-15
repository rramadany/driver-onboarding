<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'license_number' => strtoupper(Str::random(1)) . fake()->unique()->numerify('#######'), // e.g., 'D1234567'
            'license_expiry_date' => fake()->dateTimeBetween('+1 year', '+5 years'),
            'photo_path' => null, // Default to no photo

            'status' => 'draft',
            'rejection_reason' => null,
            'submitted_at' => null,
            'reviewed_at' => null,

            'created_by' => User::factory(),
            'reviewed_by' => null,
        ];
    }
}
