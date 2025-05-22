<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        // Teacher::factory()->count(20)->create();
        // Teacher::factory(100)->create();

        Teacher::create([
            'name' => 'Admin',
            'phone_number' => '12345678',
            'email' => 'admin@email.com',
            'password' => bcrypt('123'),
            'nuptk' => '12345678',
            'community' => 'Komunitas',
            'school_id' => 1
        ]);
    }
}
