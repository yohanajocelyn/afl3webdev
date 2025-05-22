<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all workshops (or adjust to target specific ones)
        $workshops = Workshop::all();

        foreach ($workshops as $workshop) {
            $workshopSlug = Str::slug($workshop->title);
            $basePath = "workshops/{$workshopSlug}/assignments";

            for ($i = 1; $i <= 4; $i++) {
                $title = "Microteaching {$i}";
                $slug = Str::slug($title);

                // Create the assignment with due_dateTime = workshop endDate
                $assignment = Assignment::create([
                    'workshop_id' => $workshop->id,
                    'title' => $title,
                    'due_dateTime' => $workshop->endDate,
                    'description' => '',
                ]);

                // Create the assignment-specific folder
                Storage::disk('public')->makeDirectory("{$basePath}/{$slug}");
            }
        }
    }
}
