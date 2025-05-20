<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),

            Select::make('gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                ])
                ->required(),

            TextInput::make('phone_number')->tel()->required(),

            TextInput::make('pfpURL')
                ->label('Profile Picture URL'),

            TextInput::make('email')->email()->required(),

            TextInput::make('password')
                ->password()
                ->required(),

            Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->required(),

            TextInput::make('nuptk')->required(),

            TextInput::make('community')->required(),

            TextInput::make('subjectTaught')->label('Subject Taught')->required(),

            Select::make('school_id')
                ->relationship('school', 'name')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('gender'),
            TextColumn::make('phone_number'),
            ImageColumn::make('pfpURL')->label('Profile'),
            TextColumn::make('email'),
            TextColumn::make('role'),
            TextColumn::make('nuptk'),
            TextColumn::make('community'),
            TextColumn::make('subjectTaught')->label('Subject'),
            TextColumn::make('school.name')->label('School'),
        ])
        ->actions([
            EditAction::make(), // 👈 This is required for the edit button to appear
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
