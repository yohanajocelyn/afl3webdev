<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Registration::class;
    public function definition(): array
    {
        return [
            'regDate'=> $this->faker->date(),
            'paymentProof'=> $this->faker->word(), //ganti dulu
            'isApproved'=> $this->faker->boolean(70),
            'courseStatus'=> $this->faker->randomElement(['assigned', 'finished']),
            'teacher_id'=> Teacher::query()->inRandomOrder()->first()->id,
            'workshop_id'=> Workshop::factory()
        ];
    }
}
