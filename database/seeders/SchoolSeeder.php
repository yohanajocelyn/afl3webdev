<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name' => 'SMP Gemilang Prestasi',
            'address' => 'Jl. Anggrek No. 9',
            'city' => 'Malang',
        ]);
    }
}
