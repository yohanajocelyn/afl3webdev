<?php

namespace Database\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meet>
 */
class MeetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'date' => $this->faker->date(),
            'description' => $this->faker->streetAddress(),
            'workshop_id' => Workshop::query()->inRandomOrder()->first()->id,
        ];
    }
}
