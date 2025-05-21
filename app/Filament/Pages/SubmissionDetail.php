<?php

namespace App\Filament\Pages;

use App\Enums\ApprovalStatus;
use App\Models\Submission;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class SubmissionDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.submission-detail';

    public ?Submission $submission = null;
    public array $state = [];

    public function mount($record): void
    {
        $this->submission = Submission::findOrFail($record);
        $this->state = [
            'status' => $this->submission->status instanceof \BackedEnum 
                ? $this->submission->status->value 
                : $this->submission->status,
            'revisionNote' => $this->submission->revisionNote,
        ];
    }

    protected function getViewData(): array
    {
        return [
            'submission' => $this->submission,
        ];
    }

    public function updateStatus()
    {
        // Validate the form data - validate the entire state array
        $this->validate([
            'state' => 'required|array',
            'state.status' => 'required',
            'state.revisionNote' => 'nullable|string',
        ]);
        
        try {
            // Extract values from state
            $status = $this->state['status'];
            $revisionNote = $this->state['revisionNote'] ?? null;
            
            // If status is a string value that needs to be converted to an enum
            if (class_exists(ApprovalStatus::class)) {
                // For string values that need to be converted to enum
                $status = ApprovalStatus::from($status);
            }
            
            // Update the submission
            $this->submission->status = $status;
            $this->submission->revisionNote = $revisionNote;
            $this->submission->save();
            
            Notification::make()
            ->title("Submission #{$this->submission->id} " . "{$this->submission->status->value}")
            ->success()
            ->send();

        } catch (\Exception $e) {
            // Log error
            Log::error('Error updating submission status: ' . $e->getMessage());
            
            // Notify user of error
            $this->notify('danger', 'There was an error updating the submission status.');
        }
    }
}
