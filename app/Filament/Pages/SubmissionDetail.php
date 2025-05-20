<?php

namespace App\Filament\Pages;

use App\Models\Submission;
use Filament\Pages\Page;

class SubmissionDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.submission-detail';

    public ?Submission $submission = null;

    public function mount($record): void
    {
        $this->submission = Submission::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'submission' => $this->submission,
        ];
    }

    public function approve(): void
    {
        $this->submission->isApproved = !$this->submission->isApproved;
        $this->submission->save();
        
        $action = $this->submission->isApproved ? 'approved' : 'revoked';
    }
}
