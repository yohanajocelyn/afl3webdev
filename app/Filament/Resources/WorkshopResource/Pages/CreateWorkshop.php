<?php

namespace App\Filament\Resources\WorkshopResource\Pages;

use App\Filament\Resources\WorkshopResource;
use App\Models\Assignment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateWorkshop extends CreateRecord
{
    protected static string $resource = WorkshopResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $data = $this->data;

        $assignmentCount = (int) ($data['assignment_count'] ?? 0);
        $dueDate = $data['assignment_due_date'] ?? null;

        // Sanitize the workshop title to create a folder name
        $folderName = Str::slug($record->title);
        $basePath = "workshops/{$folderName}";

        // Use the 'public' disk to ensure files are publicly accessible
        $disk = Storage::disk('public');

        // Create the main workshop folder and subfolders
        $disk->makeDirectory("{$basePath}/meets");
        $disk->makeDirectory("{$basePath}/assignments");

        if ($assignmentCount > 0 && $dueDate) {
            for ($i = 1; $i <= $assignmentCount; $i++) {
                $title = 'Microteaching ' . ($i);
                $slug = Str::slug($title); // Create slug like "microteaching-1"

                Log::info('Creating Assignment:', ['title' => $title, 'workshop_id' => $record->id]);

                Assignment::create([
                    'workshop_id' => $record->id,
                    'title' => $title,
                    'due_dateTime' => $dueDate,
                    'description' => ''
                ]);

                // Create the assignment folder using the slug
                $disk->makeDirectory("{$basePath}/assignments/{$slug}");
            }
        }
    }
}
