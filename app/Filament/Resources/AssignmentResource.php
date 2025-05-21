<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\RelationManagers;
use App\Models\Assignment;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Assignments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('workshop_id')
                    ->label('Workshop')
                    ->relationship('workshop', 'title')
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                DateTimePicker::make('due_dateTime')
                    ->label('Due Date')
                    ->required(),

                Textarea::make('description')
                    ->rows(4)
                    ->required(),
                TextInput::make('url')
                    ->label('Template URL')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('due_dateTime')->dateTime(),
                TextColumn::make('workshop.title')
                    ->label('Workshop')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Action::make('view')
                ->label('View Details')
                ->url(fn ($record) => route('admin-assignments.show', $record->id))
                ->openUrlInNewTab(false),
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
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
