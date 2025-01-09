<?php

namespace Database\Factories;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Teacher::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'phone_number' => $this->faker->phoneNumber(),
            'pfpURL' => $this->faker->url(),
            'email' => $this->faker->email(),
            'password' => bcrypt($this->faker->password()),
            'role' => 'user',
            'nuptk' => $this->faker->numberBetween(1000000000, 999999999999),
            'community' => $this->faker->userName(),
            'subjectTaught' => $this->faker->randomElement(['Math', 'Science', 'Language','Tech', 'Civics', 'Chinese']),
            'school_id'=> School::query()->inRandomOrder()->first()->id
        ];
    }
}
