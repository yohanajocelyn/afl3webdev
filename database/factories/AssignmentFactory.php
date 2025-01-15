<?php

namespace Database\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workshop_id' => Workshop::query()->inRandomOrder()->first()->id,
            'title' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'description' => $this->faker->text()
        ];
    }
}
