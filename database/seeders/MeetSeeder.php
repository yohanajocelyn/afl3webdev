<?php

namespace Database\Seeders;

use App\Models\Meet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meet::factory()->count(100)->create();
    }
}
