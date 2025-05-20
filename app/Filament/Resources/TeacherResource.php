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

            Placeholder::make('pfpURL')
                ->label('Profile Picture Preview')
                ->content(fn ($record) => $record && $record->pfpURL
                    ? '<img src="' . asset('storage/' . $record->pfpURL) . '" style="max-width: 200px; max-height: 150px;" />'
                    : 'No profile picture uploaded yet.')
                ->visible(fn ($get) => filled($get('pfpURL'))),

            FileUpload::make('pfpURL_file')
                ->label('Upload Profile Picture')
                ->image()
                ->directory('profile_pictures')
                ->visibility('public')
                ->reactive()
                ->afterStateUpdated(function ($state, Set $set) {
                    if ($state) {
                        $set('pfpURL', 'profile_pictures/' . $state);
                    }
                }),

            TextInput::make('pfpURL')
                ->label('Profile Picture URL')
                ->disabled() // makes the input uneditable
                ->extraAttributes(['readonly' => 'readonly', 'style' => 'pointer-events: none; user-select: none;'])
                ->dehydrated(true)
                ->required(false)
                ->afterStateHydrated(function ($state, Set $set, $record) {
                    if ($record) {
                        $set('pfpURL', $record->pfpURL);
                    }
                })
                ->dehydrateStateUsing(fn ($state) => $state ?: 'profile_pictures/defaultProfilePicture.jpg'),         

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
            DeleteAction::make(),
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
