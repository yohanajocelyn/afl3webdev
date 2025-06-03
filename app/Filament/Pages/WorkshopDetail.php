<?php

namespace App\Filament\Pages;

use App\Models\Presence;
use App\Models\Workshop;
use App\Models\Registration; // import your model
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class WorkshopDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.workshop-detail';

    public ?Workshop $workshop = null;

    public function mount($record): void
    {
        $this->workshop = Workshop::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'workshop' => $this->workshop->load('assignments'),
            'registrations' => $this->workshop->registrations()
                ->with(['teacher', 'submissions'])
                ->get(),
        ];
    }


    public function allRegistrationsApproved(): bool
    {
        return $this->workshop->registrations()->where('isApproved', false)->count() === 0;
    }

    public function toggleApproveAllRegistrations(): void
    {
        $approve = !$this->allRegistrationsApproved();

        $this->workshop->registrations()->update(['isApproved' => $approve]);

        if ($approve) {
            foreach ($this->workshop->registrations as $registration) {
                foreach ($this->workshop->meets as $meet) {
                    $presenceExists = Presence::where('registration_id', $registration->id)
                                            ->where('meet_id', $meet->id)
                                            ->exists();

                    if (! $presenceExists) {
                        Presence::create([
                            'registration_id' => $registration->id,
                            'meet_id' => $meet->id,
                            'isPresent' => false,
                            'dateTime' => now() 
                        ]);
                    }
                }
            }
        }

        Notification::make()
            ->title($approve ? 'All registrations approved' : 'All approvals revoked')
            ->success()
            ->send();

        $this->redirect(request()->header('Referer') ?? url()->current());
    }

    public function toggleApproval(int $registrationId): void
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->isApproved = !$registration->isApproved;
        $registration->save();

        // For each Meet in the Registration's Workshop,
        // check if Presence exists for this registration and meet,
        // if not, create it.
        $workshop = $registration->workshop; // assuming relationship exists

        foreach ($workshop->meets as $meet) {
            $presenceExists = Presence::where('registration_id', $registration->id)
                                    ->where('meet_id', $meet->id)
                                    ->exists();

            if (! $presenceExists) {
                Presence::create([
                    'registration_id' => $registration->id,
                    'meet_id' => $meet->id,
                    'isPresent' => false,
                    'dateTime' => now() 
                ]);
            }
        }

        Notification::make()
            ->title("Registration #{$registration->id} " . ($registration->isApproved ? 'approved' : 'unapproved'))
            ->success()
            ->send();

        $this->redirect(request()->header('Referer') ?? url()->current());
    }

    public int $visibleRegistrations = 3; // default number to show

    public function showMoreRegistrations()
    {
        $this->visibleRegistrations += 5; // show 5 more each time
    }

    public function showLessRegistrations()
    {
        $this->visibleRegistrations = 3; // reset back
    }
}
