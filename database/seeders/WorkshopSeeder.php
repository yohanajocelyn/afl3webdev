<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Workshop::factory()->count(100)->create();

        Workshop::create([
            'title' => 'Pelatihan Desain Grafis dengan Canva',
            'startDate' => '2024-03-04',
            'endDate' => '2024-03-11',
            'description' => 'Belajar desain grafis menggunakan Canva, cocok untuk pemula tanpa pengalaman desain.',
            'price' => 0,
            'imageURL' => 'https://example.com/images/canva-design.jpg',
            'isOpen' => false,
        ]);
    }
}
