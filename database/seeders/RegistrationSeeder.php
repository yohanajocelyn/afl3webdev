<?php

namespace Database\Seeders;

use App\Models\Registration;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Registration::factory()->count(100)
        ->recycle(Workshop::factory(100)->create())
        ->create();
        // Workshop::factory(100)
        // ->recycle(Workshop::factory(100)->create())
        // ->recycle(Teacher::factory(100)->recycle(School::factory(100)->create())->create())
        // ->create();
    }
}
