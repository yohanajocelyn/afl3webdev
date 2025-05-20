<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkshopResource\Pages;
use App\Filament\Resources\WorkshopResource\RelationManagers;
use App\Models\Assignment;
use App\Models\Workshop;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
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

class WorkshopResource extends Resource
{
    protected static ?string $model = Workshop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required(),

            DatePicker::make('startDate')->required(),

            DatePicker::make('endDate')->required(),

            Textarea::make('description')->required(),

            TextInput::make('price')->numeric()->required(),

            FileUpload::make('imageURL_file')
            ->label('Image')
            ->image()
            ->directory('workshop_banners') // Folder inside storage/app/public
            ->visibility('public'),

            TextInput::make('imageURL')
            ->label('Image URL')
            ->dehydrated(false)
            ->afterStateHydrated(function ($state, \Filament\Forms\Set $set, $record) {
                if ($record) {
                    $set('imageURL_text', $record->imageURL);
                }
            })
            ->required(),

            Toggle::make('isOpen')->label('Is Open')->default(true),

            TextInput::make('assignment_count')
            ->label('Assignment Amount')
            ->numeric()
            ->minValue(1)
            ->required()
            ->dehydrated(false) // not saved to workshops table
            ->afterStateHydrated(function ($state, Set $set, $record) {
                // $record is the Workshop model being edited
                if ($record) {
                    $set('assignment_count', $record->assignments()->count());
                }
            }),

            DatePicker::make('assignment_due_date')
                ->label('Assignment Due Date')
                ->required()
                ->dehydrated(false)
                ->afterStateHydrated(function ($state, Set $set, $record) {
                    if ($record && $record->assignments()->exists()) {
                        $dueDate = $record->assignments()->first()->due_date;

                        // Convert to Y-m-d format string
                        if ($dueDate instanceof \Carbon\Carbon) {
                            $dueDate = $dueDate->format('Y-m-d');
                        } else {
                            $dueDate = date('Y-m-d', strtotime($dueDate));
                        }

                        $set('assignment_due_date', $dueDate);
                    }
                }), // don't save to the workshops table
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable(),
            TextColumn::make('startDate'),
            TextColumn::make('endDate'),
            TextColumn::make('price'),
            BooleanColumn::make('isOpen'),
        ])
        ->actions([
            EditAction::make(), // 👈 This is required for the edit button to appear
            Action::make('view')
                ->label('View Details')
                ->url(fn ($record) => route('admin-workshops.show', $record->id))
                ->openUrlInNewTab(false), // open in same tab
        ]);
        ;
    }

    public static function afterCreate($record, array $data): void
    {
        $assignmentCount = (int) ($data['assignment_count'] ?? 0);
        $dueDate = $data['assignment_due_date'] ?? null;

        if ($assignmentCount > 0 && $dueDate) {
            for ($i = 0; $i < $assignmentCount; $i++) {
                Assignment::create([
                    'workshop_id' => $record->id,
                    'due_date' => $dueDate,
                ]);
            }
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
            'index' => Pages\ListWorkshops::route('/'),
            'create' => Pages\CreateWorkshop::route('/create'),
            'edit' => Pages\EditWorkshop::route('/{record}/edit'),
        ];
    }
}
