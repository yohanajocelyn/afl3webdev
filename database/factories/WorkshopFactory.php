<?php

namespace Database\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Workshop::class;
    public function definition(): array
    {
        // Generate the start date
        $startDate = $this->faker->date();
        
        // Generate the end date, ensuring it's after the start date
        $endDate = $this->faker->dateTimeBetween($startDate)->format('Y-m-d');
        
        return [
            'title' => $this->faker->sentence(5),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'description' => $this->faker->sentence(100),
            'price' => $this->faker->randomFloat(0,10000, 1000000),
            'imageURL' => $this->faker->url(),
            'isOpen' => $this->faker->boolean(30)
        ];
    }
}
