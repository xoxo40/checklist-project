<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\UserTaskResource\Pages;
use App\Models\UserTask;
use App\Models\Task;
use App\Models\Checklist;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class UserTaskResource extends Resource
{
    protected static ?string $model = UserTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('task_id')
            ->label('Tâche')
            ->options(function () {
                return Task::with('checklist')
                    ->get()
                    ->pluck('checklist.description', 'id');
            })
            ->required()
            ->reactive()
            // ... rest of your existing code
                ->afterStateUpdated(function (callable $get, callable $set) {
                    $taskId = $get('task_id');
                    $task = Task::find($taskId);

                    if ($task) {
                        $taskDetails = collect($task->task_details)->map(function ($detail) {
                            return [
                                'is_completed' => false, // Par défaut, les détails sont non complétés
                                'task_detail' => $detail,
                            ];
                        })->toArray();

                        $set('task_details', $taskDetails);
                        $set('name_employee', $task->name_employee ?? null);
                        $set('date', now()->format('Y-m-d'));
                        $set('is_completed', 'non_commence'); // Statut par défaut
                    } else {
                        $set('task_details', []);
                        $set('name_employee', null);
                        $set('date', null);
                        $set('is_completed', 'non_commence');
                    }
                }),

            Forms\Components\TextInput::make('name_employee')
                ->label('Employé')
                ->required()
                ->reactive(),

            Forms\Components\Fieldset::make('task_details')
                ->schema([
                    Forms\Components\CheckboxList::make('task_details')
                        ->label('Détails de la Tâche')
                        ->options(function (callable $get) {
                            $task = Task::find($get('task_id'));

                            if ($task) {
                                return collect($task->task_details)
                                    ->flatMap(function ($detail) {
                                        return preg_split('/(?<=\.)\s*/', $detail);  // Découper par phrase
                                    })
                                    ->mapWithKeys(fn($sentence) => [$sentence => $sentence])
                                    ->toArray();
                            }

                            return [];
                        })
                        ->columns(1)
                        ->reactive()
                        ->afterStateUpdated(function (callable $get, callable $set) {
                            $selectedDetails = $get('task_details') ?? [];

                           

                            $completedCount = count($selectedDetails) -1;

                           

                        
                            $task = Task::find($get('task_id'));
                            $taskDetails = $task ? $task->task_details : [];

                           

                            $totalDetails = count(explode("\n",$taskDetails));
                            
                          

                        
                           
                            
                        
                            if ($completedCount == 0) {
                                $set('is_completed', 'non_commence');
                            } elseif ($completedCount < $totalDetails) {
                                $set('is_completed', 'en_cours');
                            } else {
                                $set('is_completed', 'complet');
                            }
                        })
                        
                        

                ]),

                Forms\Components\ToggleButtons::make('is_completed')
                ->label('Statut')
                ->options([
                    'non_commence' => 'Non commencé',
                    'en_cours' => 'En cours',
                    'complet' => 'Terminé',
                ])
                ->colors([
                    'non_commence' => 'info',
                    'en_cours' => 'warning',
                    'complet' => 'success',

                ])    
                ->icons([
                    'non_commence' => 'heroicon-m-sparkles',
                    'en_cours' => 'heroicon-m-arrow-path',
                    'complet' => 'heroicon-m-truck',
                ])
                ->default('non_commence')
                ->required()
                ->reactive(),
            

            Forms\Components\DatePicker::make('date')
                ->label('Date de la Tâche')
                ->required(),

                Forms\Components\Textarea::make('commentaire')
    ->label('Commentaire')
    ->maxLength(255)
    ->nullable()
    ->afterStateUpdated(function ($state, callable $set, $record) {
        if ($state && $record) {
            try {
                // Vérifiez que l'enregistrement a bien un ID avant de créer une notification
                if (!$record->id) {
                    throw new \Exception('Impossible de créer une notification : l\'enregistrement n\'a pas d\'ID.');
                }

                // Création de la notification en utilisant le modèle personnalisé
                \App\Models\Notification::create([
                    'user_task_id' => $record->id, // Relation avec la tâche utilisateur
                    'message' => 'Nouveau commentaire ajouté : ' . $state, // Message
                    'is_read' => false,
                    'is_processed' => false,
                ]);

            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'insertion de la notification : ' . $e->getMessage());
                // Lever une exception compréhensible pour l'utilisateur
                throw \Filament\Exceptions\HaltException::make()
                    ->withMessage('Erreur lors de la création de la notification : ' . $e->getMessage());
            }
        }
    }),


            

                
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task.checklist.description')
                    ->label('Tâche')
                    ->sortable()
                    ->searchable(),
                    

                Tables\Columns\TextColumn::make('name_employee')
                    ->label('Employé')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('task_details')
                    ->label('Détails de la Tâche')
                    ->getStateUsing(function ($record) {
                        // Décoder `task_details` si c'est un JSON
                        $details = json_decode($record->task_details, true) ?? [];
                        
                        // Afficher les détails sous forme de liste
                        return implode(', ', array_column($details, 'task_detail'));
                    }),
                

                    Tables\Columns\BadgeColumn::make('is_completed')
    ->label('Statut')
    ->sortable()
    ->icons([
        'heroicon-o-clock' => fn ($state) => $state === 'non_commence',
        'heroicon-o-arrow-path' => fn ($state) => $state === 'en_cours',
        'heroicon-o-check-circle' => fn ($state) => $state === 'complet',
        'heroicon-o-question-mark-circle' => fn ($state) => $state === null,
    ])
    ->formatStateUsing(function ($state) {
        switch ($state) {
            case 'non_commence':
                return 'Non commencé';
            case 'en_cours':
                return 'En cours';
            case 'complet':
                return 'Terminé';
            default:
                return 'Inconnu';
        }
    })
    ->color(function ($state) {
        return match ($state) {
            'non_commence' => 'info',
            'en_cours' => 'warning',
            'complet' => 'success',
            default => 'gray',
        };
    }),

                

                    Tables\Columns\TextColumn::make('commentaire')
                     ->label('Commentaire')
                     ->default('-') // Affiche '-' si le commentaire est vide
                     ->searchable(),
                    

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
            
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserTasks::route('/'),
            'create' => Pages\CreateUserTask::route('/create'),
            'edit' => Pages\EditUserTask::route('/{record}/edit'),
        ];
    }
}
