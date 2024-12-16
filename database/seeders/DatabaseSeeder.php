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

        // Teacher::factory(100)->recycle(School::factory(100)->create())
        // ->create();

        // Registration::factory()->count(100)
        // ->recycle(Workshop::factory(100)->create())
        // ->create();

        // Meet::factory()->count(100)->create();

        // Presence::factory()->count(100)->create();

        // Assignment::factory()->count(100)->create();

        // Submission::factory()->count(100)->create();

        // Workshop::all()->each(function ($workshop) {
        //     Meet::factory()->count(3)->create(['workshop_id' => $workshop->id]);
        // });

        // Teacher::all()->each(function ($teacher) {
        //     // Select 1–3 random workshops for each teacher
        //     $workshops = Workshop::inRandomOrder()->take(rand(1, 3))->get();
        
        //     // Create registrations for the selected workshops
        //     $workshops->each(function ($workshop) use ($teacher) {
        //         Registration::factory()->create([
        //             'teacher_id' => $teacher->id,
        //             'workshop_id' => $workshop->id,
        //         ]);
        //     });
        // });

        // Meet::all()->each(function ($meet) {
        //     $registrations = Registration::where('workshop_id', $meet->workshop_id)->get();
        
        //     foreach ($registrations as $registration) {
        //         Presence::factory()->create([
        //             'registration_id' => $registration->id,
        //             'meet_id' => $meet->id
        //         ]);
        //     }
        // });

        // Workshop::all()->each(function ($workshop) {
        //     Assignment::factory()
        //         ->count(4) // Number of assignments per workshop
        //         ->create(['workshop_id' => $workshop->id]);
        // });

        Workshop::all()->each(function ($workshop) {
            // Get all assignments for this workshop
            $assignments = Assignment::where('workshop_id', $workshop->id)->get();
        
            // Get all teachers registered to this workshop
            $registrations = Registration::whereIn('id', Registration::where('workshop_id', $workshop->id)->pluck('id'))->get();
        
            // For each assignment in the workshop
            $assignments->each(function ($assignment) use ($registrations) {
                // Create submissions for each registered teacher
                $registrations->each(function ($registration) use ($assignment) {
                    Submission::factory()->create([
                        'registration_id' => $registration->id,
                        'assignment_id' => $assignment->id,
                        // Add any additional fields, e.g., 'content' => fake()->paragraph(),
                    ]);
                });
            });
        });
    }
}
