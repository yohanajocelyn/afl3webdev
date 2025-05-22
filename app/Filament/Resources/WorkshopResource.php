<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkshopResource\Pages;
use App\Filament\Resources\WorkshopResource\RelationManagers;
use App\Models\Assignment;
use App\Models\Workshop;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class WorkshopResource extends Resource
{
    protected static ?string $model = Workshop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Workshop Details')
                ->schema([
                    TextInput::make('title')->required(),
                    Textarea::make('description')->required(),
                    Grid::make()
                        ->schema([
                            DateTimePicker::make('startDate')->required(),
                            DateTimePicker::make('endDate')->required(),
                        ]),
                    TextInput::make('price')->numeric()->required(),
                    TextInput::make('certificateUrl')->nullable(),
                    Toggle::make('isOpen')->label('Open')->default(true),
                ]),

            Section::make('Workshop Image')
                ->schema([
                    Grid::make()
                        ->schema([
                            Card::make()
                                ->schema([
                                    Placeholder::make('imageURLPreview')
                                        ->label('Workshop Banner Preview')
                                        ->content(fn ($record) => new HtmlString(
                                            $record && $record->imageURL
                                                ? '<img src="' . asset('storage/' . $record->imageURL) . '" style="max-width: 200px; max-height: 150px;" />'
                                                : '<img src="' . asset('images/Poster-Bebras-CT-2025.jpeg') . '" style="max-width: 200px; max-height: 150px;" />'
                                        )),
                                ])->columnSpan(1),

                            Card::make()
                                ->schema([
                                    FileUpload::make('imageURL_file')
                                        ->label('Image')
                                        ->image()
                                        ->directory('workshop_banners')
                                        ->visibility('public')
                                        ->afterStateUpdated(function ($state, Set $set) {
                                            if ($state) {
                                                $set('imageURL', 'workshop_banners/' . $state);
                                            }
                                        }),

                                    TextInput::make('imageURL')
                                        ->label('Image URL')
                                        ->disabled()
                                        ->extraAttributes([
                                            'readonly' => 'readonly',
                                            'style' => 'pointer-events: none; user-select: none;',
                                        ])
                                        ->dehydrated(true)
                                        ->default('images/Poster-Bebras-CT-2025.jpeg')
                                        ->dehydrateStateUsing(fn ($state) => $state ?: 'images/Poster-Bebras-CT-2025.jpeg'),
                                ])->columnSpan(1),
                        ])->columns(2),
                ]),

            Section::make('Assignments & Certificates')
                ->schema([
                    Card::make()
                        ->schema([
                            Grid::make()
                                ->schema([
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
                                    
                                    DateTimePicker::make('assignment_due_date')
                                        ->label('Assignment Due Date')
                                        ->required()
                                        ->dehydrated(false) // Don't save to workshops table
                                        ->afterStateHydrated(function (Set $set, $record) {
                                            if ($record && $record->assignments()->exists()) {
                                                $dueDate = $record->assignments()->first()->due_dateTime;

                                                $set('assignment_due_date', \Carbon\Carbon::parse($dueDate));
                                            }
                                        }),
                                ])->columns(2),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('title')->searchable(),
            TextColumn::make('startDate'),
            TextColumn::make('endDate'),
            TextColumn::make('price'),
            BooleanColumn::make('isOpen'),
        ])
        ->actions([
            Action::make('view')
                ->label('View Details')
                ->url(fn ($record) => route('admin-workshops.show', $record->id))
                ->openUrlInNewTab(false), // open in same tab
            EditAction::make(), // 👈 This is required for the edit button to appear
            DeleteAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
        ])
        ;
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
