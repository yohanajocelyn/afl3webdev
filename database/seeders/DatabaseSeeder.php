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
use PhpParser\Node\Expr\Assign;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DefaultUserSeeder::class,
            SchoolSeeder::class,
            TeacherSeeder::class,
            WorkshopSeeder::class,
            AssignmentSeeder::class,
        ]);
    }
}
