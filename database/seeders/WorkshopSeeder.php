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

        // Workshop::create([
        //     'title' => 'Pelatihan Desain Grafis dengan Canva',
        //     'startDate' => '2024-03-04',
        //     'endDate' => '2024-03-11',
        //     'description' => 'Belajar desain grafis menggunakan Canva, cocok untuk pemula tanpa pengalaman desain.',
        //     'price' => 0,
        //     'imageURL' => 'https://example.com/images/canva-design.jpg',
        //     'isOpen' => false,
        // ]);

        // Workshop::create([
        //     'title' => 'Workshop Dasar Pemrograman Web',
        //     'startDate' => '2024-01-08',
        //     'endDate' => '2024-01-15',
        //     'description' => 'Pelajari dasar-dasar pemrograman web, mulai dari HTML, CSS, hingga JavaScript.',
        //     'price' => 50000,
        //     'imageURL' => 'https://example.com/images/web-programming.jpg',
        //     'isOpen' => true,
        // ]);

        // Workshop::create([
        //     'title' => 'Kelas Fotografi untuk Pemula',
        //     'startDate' => '2024-02-12',
        //     'endDate' => '2024-02-19',
        //     'description' => 'Tingkatkan kemampuan fotografi Anda dengan teknik dasar yang mudah dipahami.',
        //     'price' => 75000,
        //     'imageURL' => 'https://example.com/images/photography.jpg',
        //     'isOpen' => true,
        // ]);
    }
}
