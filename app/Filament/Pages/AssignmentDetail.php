<?php

namespace App\Filament\Pages;

use App\Enums\ApprovalStatus;
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
                ->url(fn ($record) => route('admin-submissions.show', $record->id)),
            
            BadgeColumn::make('submissions_status')
                ->label('Status')
                ->state(fn ($record) => $record->submissions->isNotEmpty() ? 'Submitted' : 'Empty')
                ->colors([
                    'success' => 'Submitted',
                    'danger' => 'Empty',
                ]),

            TextColumn::make('approval_status')
                ->label('Approval Status')
                ->state(fn ($record) => $record->submissions->first()?->status?->value ?? 'N/A')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'approved' => 'success',
                    'pending' => 'warning',
                    'rejected' => 'danger',
                    default => 'gray',
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [];
    }
}
