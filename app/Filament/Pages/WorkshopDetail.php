<?php

namespace App\Filament\Pages;

use App\Models\Workshop;
use Filament\Pages\Page;

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
            'workshop' => $this->workshop,
        ];
    }
}
