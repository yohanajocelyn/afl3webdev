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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('regDate')
                    ->label('Registration Date')
                    ->default(fn () => Carbon::today())
                    ->required(),

                Placeholder::make('paymentProofPreview')
                    ->label('Payment Proof')
                    ->content(fn ($record) => $record && $record->paymentProof
                        ? '<img src="' . asset('storage/' . $record->paymentProof) . '" style="max-width: 200px; max-height: 150px;" />'
                        : 'No payment proof uploaded yet.'),

                FileUpload::make('paymentProof')
                    ->label('Upload Payment Proof')
                    ->image()
                    ->directory('payment-proofs')
                    ->visible(fn ($get) => empty($get('paymentProof'))) // Show upload only if no existing paymentProof
                    ->nullable()
                    ->dehydrateStateUsing(fn ($state) => $state ?: 'registration_proofs/'),

                Toggle::make('isApproved')
                    ->label('Approved')
                    ->default(false),

                Select::make('courseStatus')
                    ->options([
                        'assigned' => 'Assigned',
                        'finished' => 'Finished',
                    ])
                    ->required(),

                Select::make('teacher_id')
                    ->label('Teacher')
                    ->relationship('teacher', 'name')
                    ->required(),

                Select::make('workshop_id')
                    ->label('Workshop')
                    ->required()
                    ->searchable()
                    ->options(Workshop::all()->pluck('title', 'id')->toArray()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('regDate')->label('Registration Date')->date(),
                TextColumn::make('paymentProof')->limit(50)->wrap(),
                BooleanColumn::make('isApproved')->label('Approved')->boolean(),
                TextColumn::make('courseStatus')->label('Course Status'),
                TextColumn::make('teacher.name')->label('Teacher'),
                TextColumn::make('workshop.title')->label('Workshop'),
                TextColumn::make('created_at')->dateTime()->label('Created At'),
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
