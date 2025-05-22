<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\Workshop;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Registration Details')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('teacher_id')
                                    ->label('Teacher')
                                    ->relationship('teacher', 'name')
                                    ->required(),
                                
                                Select::make('workshop_id')
                                    ->label('Workshop')
                                    ->required()
                                    ->searchable()
                                    ->options(Workshop::all()->pluck('title', 'id')->toArray()),
                            ])->columns(2),
                        
                        Grid::make()
                            ->schema([
                                Select::make('courseStatus')
                                    ->options([
                                        'assigned' => 'Assigned',
                                        'finished' => 'Finished',
                                    ])
                                    ->required(),
                                
                                Toggle::make('isApproved')
                                    ->label('Approved')
                                    ->default(false),
                            ])->columns(2),
                    ]),
                
                Section::make('Payment Verification')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Card::make()
                                    ->schema([
                                        Placeholder::make('paymentProofPreview')
                                            ->label('Payment Proof')
                                            ->content(fn ($record) => new HtmlString(
                                                $record && $record->paymentProof
                                                    ? '<img src="' . asset('storage/' . $record->paymentProof) . '" style="max-width: 200px; max-height: 150px;" />'
                                                    : '<img src="' . asset('images/pelatihanGratis.jpg') . '" style="max-width: 200px; max-height: 150px;" />'
                                            )),
                                    ])->columnSpan(1),
                                
                                Card::make()
                                    ->schema([
                                        FileUpload::make('paymentProof_file')
                                            ->label('Upload Payment Proof')
                                            ->image()
                                            ->directory('registration_proofs')
                                            ->visibility('public')
                                            ->nullable()
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if ($state) {
                                                    $set('paymentProof', 'registration_proofs/' . $state);
                                                }
                                            }),
                                        
                                        TextInput::make('paymentProof')
                                            ->label('Payment Proof Path')
                                            ->default('registration_proofs/pelatihanGratis.jpg')
                                            ->disabled()
                                            ->dehydrated(true),
                                    ])->columnSpan(1),
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher.name')->label('Teacher'),
                TextColumn::make('workshop.title')->label('Workshop'),
                BooleanColumn::make('isApproved'),
                TextColumn::make('courseStatus')->badge(),
            ])
            ->filters([
                // add filters if you want
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function afterCreate(Model $record): void
    {
        static::afterSave($record);
    }

    public static function afterUpdate(Model $record): void
    {
        static::afterSave($record);
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
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
