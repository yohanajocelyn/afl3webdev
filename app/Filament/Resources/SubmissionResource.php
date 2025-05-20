<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubmissionResource\Pages;
use App\Filament\Resources\SubmissionResource\RelationManagers;
use App\Models\Assignment;
use App\Models\Registration;
use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('registration_id')
                    ->label('Teacher - Workshop')
                    ->options(function () {
                        return Registration::with(['teacher', 'workshop'])->get()
                            ->mapWithKeys(function ($registration) {
                                $label = "{$registration->teacher->name} - {$registration->workshop->title}";
                                return [$registration->id => $label];
                            });
                    })
                    ->searchable()
                    ->required(),

                Select::make('assignment_id')
                    ->label('Assignment - Workshop')
                    ->options(function () {
                        return Assignment::with('workshop')->get()
                            ->mapWithKeys(function ($assignment) {
                                $label = "{$assignment->title} - {$assignment->workshop->title}";
                                return [$assignment->id => $label];
                            });
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('subject')->required(),
                TextInput::make('title')->required(),
                Select::make('educationLevel')
                    ->options([
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA sederajat' => 'SMA sederajat',
                    ])
                    ->required(),

                TextInput::make('studentAmount')
                    ->numeric()
                    ->required(),

                TextInput::make('duration')
                    ->numeric()
                    ->required(),

                Toggle::make('isOnsite')
                    ->label('Is Onsite')
                    ->required(),

                TextInput::make('url')->required(),

                Textarea::make('note'),

                Hidden::make('isApproved')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration.teacher.name')
                    ->label('Teacher')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('registration.workshop.title')
                    ->label('Workshop')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')->searchable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('educationLevel'),

                TextColumn::make('url')->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('view')
                ->label('View Details')
                ->url(fn ($record) => route('admin-submissions.show', $record->id))
                ->openUrlInNewTab(false),
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
            'index' => Pages\ListSubmissions::route('/'),
            'create' => Pages\CreateSubmission::route('/create'),
            'edit' => Pages\EditSubmission::route('/{record}/edit'),
        ];
    }
}
