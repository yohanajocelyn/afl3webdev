<?php

namespace App\Filament\Resources\MeetResource\Pages;

use App\Filament\Resources\MeetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMeet extends CreateRecord
{
    protected static string $resource = MeetResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        
        // Sanitize the workshop title to create a folder name
        $workshopTitle = preg_replace('/\s+/', '', $record->workshop->title);
        $meetTitle = preg_replace('/\s+/', '', $record->title);

        // Define the path for the new meet folder
        $meetPath = "workshops/{$workshopTitle}/meets/{$meetTitle}";

        // Create the directory using the 'public' disk
        Storage::disk('public')->makeDirectory($meetPath);
    }
}
