<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\School;
use App\Models\Submission;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Workshop;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Teacher::factory(100)->recycle(School::factory(100)->create())
        ->create();

        Registration::factory()->count(100)
        ->recycle(Workshop::factory(100)->create())
        ->create();

        Meet::factory()->count(100)->create();

        Presence::factory()->count(100)->create();

        Assignment::factory()->count(100)->create();

        Submission::factory()->count(100)->create();
    }
}
