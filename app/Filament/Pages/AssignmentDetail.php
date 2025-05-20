<?php

namespace App\Filament\Pages;

use App\Models\Assignment;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Builder;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class AssignmentDetail extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.assignment-detail';

    public Assignment $assignment;
    public Workshop $workshop;

    public function mount($record): void
    {
        $this->assignment = Assignment::with('workshop.registrations.teacher', 'workshop.registrations.submissions')
            ->findOrFail($record);
        $this->workshop = $this->assignment->workshop;
    }

    protected function getViewData(): array
    {
        return [
            'assignment' => $this->assignment,
            'workshop' => $this->workshop,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Registration::query()
            ->where('workshop_id', $this->workshop->id)
            ->with(['teacher', 'submissions' => fn ($q) => $q->where('assignment_id', $this->assignment->id)]);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('teacher.name')
                ->label('Participant')
                ->url(fn ($record) => '/teacherprofile?teacherId='.$record->teacher->id),
            
            BadgeColumn::make('submissions_status')
                ->label('Status')
                ->state(fn ($record) => $record->submissions->isNotEmpty() ? 'Submitted' : 'Empty')
                ->colors([
                    'success' => 'Submitted',
                    'danger' => 'Empty',
                ]),
                
            IconColumn::make('approval_status')
                ->label('Approve')
                ->state(fn ($record) => $record->submissions->first()?->isApproved ?? false)
                ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                ->action(fn ($record) => $this->toggleApproval($record)),
        ];
    }

    public function toggleApproval($record): void
    {
        $submission = $record->submissions->firstWhere('assignment_id', $this->assignment->id);
        
        if ($submission) {
            $submission->update(['isApproved' => !$submission->isApproved]);
            $this->dispatch('approval-toggled', approved: $submission->isApproved);
        }
    }

    protected function getTableActions(): array
    {
        return [];
    }
}
