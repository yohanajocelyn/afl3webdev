<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAssignment extends CreateRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function afterCreate(): void
    {
        $assignment = $this->record;

        // Slugify workshop title and assignment title
        $workshopSlug = Str::slug($assignment->workshop->title);
        $assignmentSlug = Str::slug($assignment->title);

        // Build path
        $folderPath = "workshops/{$workshopSlug}/assignments/{$assignmentSlug}";

        // Create directory on the public disk
        Storage::disk('public')->makeDirectory($folderPath);
    }
}
