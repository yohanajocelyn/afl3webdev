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
        // Teacher::factory()->count(100)->create();
        // Teacher::factory(100)->recycle(School::factory(100)->create())
        // ->create();

        // protected $fillable = ['name', 'gender', 'phone_number', 'pfpURL', 'role', 'email', 'password', 'nuptk', 'community', 'subjectTaught', 'school_id'];
        Teacher::create([
            'name' => 'Admin',
            'gender' => 'female',
            'phone_number' => '12345678',
            'pfpUrl' => 'defaultImg',
            'role' => Role::Admin,
            'email' => 'admin2@email.com',
            'password' => bcrypt('12345678'),
            'nuptk' => '12345678',
            'community' => 'AdminCommunity',
            'subjectTaught' => 'AdminSubject',
            'school_id' => 1
        ]);
    }
}
