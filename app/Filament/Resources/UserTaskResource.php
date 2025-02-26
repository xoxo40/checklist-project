<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserTaskResource\Pages;
use App\Filament\Resources\UserTaskResource\RelationManagers;
use App\Models\UserTask;
use App\Models\Task;
use App\Models\Checklist;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class UserTaskResource extends Resource
{
    protected static ?string $model = UserTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Statut';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('task_id')
                ->label('Tâche')
                ->relationship('task', 'checklist_id')
                ->required()
                ->reactive()
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
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([])
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
                Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);       
    }

    public static function afterCreate(UserTask $userTask): void
    {
        self::updateStats();
    }

    public static function afterUpdate(UserTask $userTask): void
    {
        self::updateStats();
    }

    public static function afterDelete(UserTask $userTask): void
    {
        self::updateStats();
    }

    // Cette méthode permet de recalculer les données du graphique
    protected static function updateStats(): void
    {
        // Cela peut être une simple notification ou une action après chaque création/modification
        // Vous pouvez également envisager de stocker des statistiques agrégées dans une table à chaque mise à jour.
        // Par exemple, recalculer le nombre de tâches créées chaque jour et enregistrer dans une table de statistiques.

        // Exemple pour notifier ou recalculer les graphiques après mise à jour
        event(new \App\Events\StatsUpdated());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserTasks::route('/'),
            //'create' => Pages\CreateUserTask::route('/create'),
            'edit' => Pages\EditUserTask::route('/{record}/edit'),
        ];
    }



    public static function canCreate(): bool
{
    return false; // Désactive l'action "Créer"
}

}