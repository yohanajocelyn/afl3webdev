<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bebras.uc.ac.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('adminBebras123'), // 👈 Use Hash::make
            ]
        );
    }
}

