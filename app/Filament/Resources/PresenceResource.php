<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Filament\Resources\PresenceResource\RelationManagers;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->label('Registration')
                    ->options(Registration::all()->mapWithKeys(fn ($reg) => [
                        $reg->id => 'Reg #' . $reg->id . ' - Workshop: ' . ($reg->workshop->title ?? 'N/A'),
                    ]))
                    ->searchable()
                    ->required(),

                Toggle::make('isPresent')
                    ->label('Is Present')
                    ->default(false),

                DateTimePicker::make('dateTime')
                    ->label('Date & Time')
                    ->required()
                    ->default(now()),
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

                TextColumn::make('registration.id')
                    ->label('Registration ID')
                    ->sortable(),

                BooleanColumn::make('isPresent')
                    ->label('Present')
                    ->boolean(),

                TextColumn::make('dateTime')
                    ->label('Date & Time')
                    ->dateTime('M d, Y H:i'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
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
