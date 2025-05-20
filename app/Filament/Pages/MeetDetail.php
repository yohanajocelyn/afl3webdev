<?php

namespace App\Filament\Pages;

use App\Models\Meet;
use Filament\Pages\Page;

class MeetDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.meet-detail';

    public ?Meet $meet = null;
    public $workshop;
    public $registrations;

    public function mount($record): void
    {
        // Find the meet or throw a 404
        $this->meet = Meet::with('workshop')->findOrFail($record);
        
        // Get the associated workshop
        $this->workshop = $this->meet->workshop;
        
        // Load registrations with their teachers, schools, and presences for this meet
        $this->registrations = $this->workshop->registrations()
            ->with(['teacher.school', 'presences' => function ($query) {
                $query->where('meet_id', $this->meet->id);
            }])
            ->get();
    }

    /**
     * Get data to be passed to the view
     * 
     * @return array
     */
    protected function getViewData(): array
    {
        return [
            'meet' => $this->meet,
            'workshop' => $this->workshop,
            'registrations' => $this->registrations,
            'pageTitle' => $this->meet->title . ' - Meet Details',
        ];
    }
}
