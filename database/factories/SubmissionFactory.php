<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_id' => Registration::query()->inRandomOrder()->first()->id,
            'assignment_id' => Assignment::query()->inRandomOrder()->first()->id,
            'subject' => $this->faker->word(),
            'title' => $this->faker->word(),
            'educationLevel' => $this->faker->randomElement(['TK', 'SD', 'SMP', 'SMA sederajat']),
            'studentAmount' => $this->faker->numberBetween(1, 100),
            'duration' => $this->faker->numberBetween(60, 120),
            'isOnsite' => $this->faker->boolean(),
            'note' => $this->faker->word(),
            'url' => $this->faker->word()
        ];
    }
}
