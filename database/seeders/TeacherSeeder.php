<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::factory()->count(100)->create();
        // Teacher::factory(100)->recycle(School::factory(100)->create())
        // ->create();
    }
}
