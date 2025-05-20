<?php

namespace App\Filament\Resources\WorkshopResource\Pages;

use App\Filament\Resources\WorkshopResource;
use App\Models\Assignment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateWorkshop extends CreateRecord
{
    protected static string $resource = WorkshopResource::class;

    protected function afterCreate(): void
    {

        $record = $this->record;
        $data = $this->data;

        $assignmentCount = (int) ($data['assignment_count'] ?? 0);
        $dueDate = $data['assignment_due_date'] ?? null;

        if ($assignmentCount > 0 && $dueDate) {
            for ($i = 1; $i <= $assignmentCount + 2; $i++) {
                if ($i === 1) {
                    $title = 'pre-test';
                } else if ($i === 2) {
                    $title = 'post-test';
                } else {
                    $title = 'Assignment ' . ($i - 2);
                }

                Log::info('Creating Assignment:', ['title' => $title, 'workshop_id' => $record->id]);

                Assignment::create([
                    'workshop_id' => $record->id,
                    'title' => $title,
                    'date' => $dueDate,  // or 'due_date' if that is the correct field
                    'description' => ""
                ]);
            }
        }
    }
}
