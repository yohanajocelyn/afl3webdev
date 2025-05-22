<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workshop = Workshop::create([
            'title' => 'Pelatihan Desain Grafis dengan Canva',
            'startDate' => Carbon::now(), // today
            'endDate' => Carbon::now()->addDays(3), // 3 days later
            'description' => 'Belajar desain grafis menggunakan Canva, cocok untuk pemula tanpa pengalaman desain.',
            'price' => 0,
            'isOpen' => false,
        ]);

        // Generate a folder name from the workshop title
        $folderName = Str::slug($workshop->title);

        // Define the base path
        $basePath = "workshops/{$folderName}";

        // Create directories on the 'public' disk
        $disk = Storage::disk('public');
        $disk->makeDirectory("{$basePath}/meets");
        $disk->makeDirectory("{$basePath}/assignments");
    }
}
