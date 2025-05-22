<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('phone_number')->tel()->required(),
            TextInput::make('email')->email()->required(),

            TextInput::make('password')
                ->password()
                ->label('Password')
                ->required(fn (string $context): bool => $context === 'create') // Only required when creating
                ->dehydrated(fn ($state) => filled($state)) // Only save if filled
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null) // Hash only if filled
                ->afterStateHydrated(function ($state, Set $set) {
                    $set('password', ''); // Clear the field so it doesn't show hashed value
                }),

            TextInput::make('nuptk')->required(),
            TextInput::make('community')->nullable(),

            Select::make('school_id')
                ->relationship('school', 'name')
                ->required(),

            Select::make('mentor_id')
                ->relationship('mentor', 'name')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email'),
            TextColumn::make('school.name')->label('School')->sortable(),
            TextColumn::make('mentor.name')->label('Mentor')->sortable(),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
