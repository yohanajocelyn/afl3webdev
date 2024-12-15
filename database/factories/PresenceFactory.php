<?php

namespace Database\Factories;

use App\Models\Meet;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presence>
 */
class PresenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meet_id' => Meet::query()->inRandomOrder()->first()->id,
            'registration_id' => Registration::query()->inRandomOrder()->first()->id,
            'isPresent' => $this->faker->boolean(),
            'dateTime' => $this->faker->dateTime($max = 'now', $timezone = null)
        ];
    }
}
