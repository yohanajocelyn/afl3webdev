<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Filament\Resources\PresenceResource\RelationManagers;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('meet_id')
                    ->label('Meet')
                    ->options(Meet::all()->pluck('title', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('registration_id')
                    ->label('Teacher - Workshop')
                    ->options(function () {
                        return Registration::with(['teacher', 'workshop'])->get()
                            ->mapWithKeys(function ($registration) {
                                $label = "{$registration->teacher->name} - Workshop: {$registration->workshop->title}";
                                return [$registration->id => $label];
                            });
                    })
                    ->searchable()
                    ->required(),

                DateTimePicker::make('dateTime')
                    ->required()
                    ->default(Carbon::now()),

                FileUpload::make('proofUrl_file')
                    ->label('Upload Bukti Kehadiran')
                    ->image()
                    ->disk('public')
                    ->maxSize(512) // Maksimum 512 KB
                    ->directory(function ($get, $record) {
                        if (!$record || !$record->meet || !$record->meet->workshop) {
                            return 'workshops/unknown/unknown';
                        }

                        $workshopTitle = Str::of($record->meet->workshop->title)->replace(' ', '');
                        $meetTitle = Str::of($record->meet->title)->replace(' ', '');

                        return "workshops/{$workshopTitle}/meets/{$meetTitle}";
                    })
                    ->visibility('public')
                    ->afterStateUpdated(function ($state, $set, $get, $record) {
                        if ($state && $record && $record->meet && $record->meet->workshop) {
                            $workshopTitle = Str::of($record->meet->workshop->title)->replace(' ', '');
                            $meetTitle = Str::of($record->meet->title)->replace(' ', '');
                            $set('proofUrl', "workshops/{$workshopTitle}/meets/{$meetTitle}/{$state}");
                        }
                    }),
                
                TextInput::make('proofUrl')
                    ->label('Proof of Attendance Path')
                    ->disabled()
                    ->extraAttributes(['readonly' => 'readonly', 'style' => 'pointer-events: none; user-select: none;'])
                    ->dehydrated(true)
                    ->dehydrateStateUsing(function ($state) {
                        return $state ?: ' ';
                    }),

                Select::make('status')->options([
                    'approved' => 'Approved',
                    'pending' => 'Pending',
                    'rejected' => 'Rejected',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('meet.title')
                    ->label('Meet Title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('dateTime')
                    ->label('Date & Time')
                    ->dateTime('M d, Y H:i'),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }
}
