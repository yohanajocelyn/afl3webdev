<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use App\Models\Meet;
use App\Models\Presence;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $isApproved = $record->isApproved;
        $meets = Meet::where('workshop_id', $record->workshop_id)->get();

        if ($isApproved){
            foreach($meets as $meet){
                Presence::firstOrCreate([
                    'meet_id' => $meet->id,
                    'registration_id' => $record->id,
                    'isPresent' => false,
                    'dateTime' => now() 
                ]);
            }
        }
    }
}
