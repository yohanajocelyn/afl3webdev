<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Enums\ApprovalStatus;
use App\Filament\Resources\RegistrationResource;
use App\Models\Meet;
use App\Models\Presence;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateRegistration extends CreateRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $isApproved = $record->isApproved;
        $meets = Meet::where('workshop_id', $record->workshop_id)->get();

        if ($isApproved){
            foreach($meets as $meet){
                Presence::firstOrCreate([
                    'meet_id' => $meet->id,
                    'registration_id' => $record->id,
                    'status' => ApprovalStatus::Pending,
                    'dateTime' => now() 
                ]);
            }
        }
    }
}
