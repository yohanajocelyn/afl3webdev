<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubmissionResource\Pages;
use App\Filament\Resources\SubmissionResource\RelationManagers;
use App\Models\Assignment;
use App\Models\Registration;
use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Assignment Details')
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('registration_id')
                                ->label('Teacher - Workshop')
                                ->options(function () {
                                    return Registration::with(['teacher', 'workshop'])->get()
                                        ->mapWithKeys(function ($registration) {
                                            $label = "{$registration->teacher->name} - Workshop: {$registration->workshop->title}";
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
                        ])->columns(2),

                    TextInput::make('title')
                        ->required()
                        ->columnSpan('full'),
                        
                    Textarea::make('note')
                        ->nullable()
                        ->columnSpan('full'),
                ]),

            Section::make('Submission')
                ->schema([
                    Grid::make()
                        ->schema([
                            Card::make()
                                ->schema([
                                    FileUpload::make('pdf_file')
                                        ->label('PDF Document')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(1024) // 1MB
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            if (!$state) return;
                                            
                                            // Get the workshop details through registration relation
                                            $registrationId = $get('registration_id');
                                            $assignmentId = $get('assignment_id');
                                            $title = $get('title');
                                            
                                            if (!$registrationId || !$assignmentId) return;
                                            
                                            // Using DB queries to get the necessary information
                                            $registration = DB::table('registrations')->find($registrationId);
                                            if (!$registration) return;
                                            
                                            $workshop = DB::table('workshops')->find($registration->workshop_id);
                                            if (!$workshop) return;
                                            
                                            $assignment = DB::table('assignments')->find($assignmentId);
                                            if (!$assignment) return;

                                            $assignmentTitle = $assignment->title;
                                            $assignmentNumber = (int) Str::after($assignmentTitle, 'Microteaching ');
                                            
                                            // Prepare the safe workshop title (no spaces)
                                            $workshopTitle = Str::slug($workshop->title);
                                            
                                            // Create the directory structure
                                            $directory = "workshops/{$workshopTitle}/assignments/microteaching{$assignmentNumber}";
                                            
                                            // Create a safe filename from the title or use a default
                                            $safeTitle = $title ? Str::slug($title) : 'submission';
                                            $filename = "{$safeTitle}.pdf";
                                            
                                            // Set the path for the TextInput
                                            $fullPath = "{$directory}/{$filename}";
                                            $set('path', $fullPath);
                                        })
                                        ->directory(function (callable $get) {
                                            // Dynamically set directory based on registration and assignment
                                            $registrationId = $get('registration_id');
                                            $assignmentId = $get('assignment_id');
                                            
                                            if (!$registrationId || !$assignmentId) return 'uploads';
                                            
                                            // Using DB queries to get the necessary information
                                            $registration = DB::table('registrations')->find($registrationId);
                                            if (!$registration) return 'uploads';
                                            
                                            $workshop = DB::table('workshops')->find($registration->workshop_id);
                                            if (!$workshop) return 'uploads';

                                            $assignment = DB::table('assignments')->find($assignmentId);
                                            if (!$assignment) return 'uploads';
                                            
                                            // Prepare the safe workshop title (no spaces)
                                            $workshopTitle = Str::slug($workshop->title);

                                            $assignmentTitle = $assignment->title;
                                            $assignmentNumber = (int) Str::after($assignmentTitle, 'Microteaching ');
                                            
                                            // Create the directory structure
                                            return "workshops/{$workshopTitle}/assignments/microteaching{$assignmentNumber}";
                                        })
                                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get) {
                                            // Use the submission title to name the file
                                            $title = $get('title') ?? 'submission';
                                            return Str::slug($title) . '.pdf';
                                        })
                                        ->visibility('public'),
                                        
                                    TextInput::make('url')
                                        ->required(),
                                        
                                    TextInput::make('path')
                                        ->disabled()
                                        ->dehydrated(true),
                                ])->columnSpan(1),
                                
                            Card::make()
                                ->schema([
                                    Select::make('status')
                                        ->options([
                                            'approved' => 'Approved',
                                            'pending' => 'Pending',
                                            'rejected' => 'Rejected',
                                        ])
                                        ->default('pending'),
                                        
                                    Textarea::make('revisionNote')
                                        ->nullable()
                                        ->label('Revision Notes')
                                        ->helperText('Provide feedback if assignment needs revision'),
                                ])->columnSpan(1),
                        ])->columns(2),
                ]),
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

                TextColumn::make('url')->limit(30),
                IconColumn::make('isApproved')
                    ->boolean(),
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
