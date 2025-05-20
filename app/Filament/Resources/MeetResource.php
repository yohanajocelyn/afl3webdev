<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetResource\Pages;
use App\Filament\Resources\MeetResource\RelationManagers;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\Workshop;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeetResource extends Resource
{
    protected static ?string $model = Meet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('date')
                    ->required(),

                TextInput::make('description')
                    ->required()
                    ->maxLength(65535),

                Select::make('workshop_id')
                    ->label('Workshop')
                    ->required()
                    ->searchable()
                    ->options(Workshop::all()->pluck('title', 'id')->toArray())
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('date')->date(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('workshop.title')->label('Workshop'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                // add filters if needed
            ])
            ->actions([
                Action::make('view')
                ->label('View Details')
                ->url(fn ($record) => route('admin-meets.show', $record->id))
                ->openUrlInNewTab(false),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    // Hook after Meet is created, to create Presence for all approved Registrations of the Workshop
    public static function afterCreate(Model $record): void
    {
        // $record is the newly created Meet
        $workshopId = $record->workshop_id;

        // Get all approved registrations for that workshop
        $approvedRegistrations = Registration::where('workshop_id', $workshopId)
            ->where('isApproved', true)
            ->get();

        foreach ($approvedRegistrations as $registration) {
            Presence::create([
                'meet_id' => $record->id,
                'registration_id' => $registration->id,
                'isPresent' => false, // default to false, or adjust if needed
                'dateTime' => now(),
            ]);
        }
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeets::route('/'),
            'create' => Pages\CreateMeet::route('/create'),
            'edit' => Pages\EditMeet::route('/{record}/edit'),
        ];
    }
}
