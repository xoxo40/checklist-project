<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use App\Models\Checklist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Gestion des Tâches';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('checklist_id')
                    ->label('Titre de la Tâche')
                    ->relationship('checklist', 'description')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $get, callable $set) {
                        $checklist = Checklist::find($get('checklist_id'));
                        if ($checklist && $checklist->employee) {
                            $set('name_employee', $checklist->employee->username); // Mettre à jour le nom de l'employé
                        } else {
                            $set('name_employee', null); // Réinitialiser si aucune checklist ou employé sélectionné
                        }
                    }),

                Forms\Components\TextInput::make('name_employee')
                    ->label('Nom de l\'Employé')
                    ->nullable() // Rendre le champ facultatif pour éviter l'erreur de validation
                    ->maxLength(255),

                Forms\Components\Textarea::make('task_details')
                    ->label('Détail de la Tâche (une tâche par ligne)')
                    ->rows(6)
                    ->required(),

                    Forms\Components\Select::make('recurrence')
                    ->label('Récurrence (optionnelle)')
                    ->options([
                        'lundi' => 'Lundi',
                        'mardi' => 'Mardi',
                        'mercredi' => 'Mercredi',
                        'jeudi' => 'Jeudi',
                        'vendredi' => 'Vendredi',
                        'samedi' => 'Samedi',
                        'dimanche' => 'Dimanche',
                    ])
                    ->placeholder('Aucune récurrence')
                    ->reactive() // Rendre réactif pour surveiller les changements
                    ->nullable()
                    ->helperText('Sélectionnez un jour si la tâche doit être répétée automatiquement chaque jour de la semaine.'),
    
                Forms\Components\DatePicker::make('date')
                    ->label('Date de démarrage')
                    ->required()
                    ->disabled(fn (callable $get) => $get('recurrence') !== null), // Désactiver si une récurrence est sélectionnée
    
                Forms\Components\DatePicker::make('deadline')
                    ->label('Date d\'échéance')
                    ->required()
                    ->disabled(fn (callable $get) => $get('recurrence') !== null), // Désactiver si une récurrence est sélectionnée
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('checklist.description')
                    ->label('Titre de la Tâche')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name_employee')
                    ->label('Nom de l\'Employé')
                    ->sortable()
                    ->searchable(),

                // Colonne personnalisée pour afficher les détails des tâches sous forme de cases à cocher
                Tables\Columns\TextColumn::make('task_details')
                    ->label('Détails des Tâches')
                    ->formatStateUsing(function (Task $record) {
                        $details = explode("\n", $record->task_details);
                        return implode('<br>', array_map(fn($task) => '<label><input type="checkbox" disabled> ' . e(trim($task)) . '</label>', $details));
                    })
                    ->html(), // Activez l'HTML pour permettre l'affichage des cases à cocher

                Tables\Columns\TextColumn::make('date')
                    ->label('Date de démarrage')
                    ->date(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label(" Dta d'échéance")
                    ->date(),  
                    
                Tables\Columns\TextColumn::make('recurrence')
                    ->label('Récurrence')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $days = [
                            'lundi' => 'Lundi',
                            'mardi' => 'Mardi',
                            'mercredi' => 'Mercredi',
                            'jeudi' => 'Jeudi',
                            'vendredi' => 'Vendredi',
                            'samedi' => 'Samedi',
                            'dimanche' => 'Dimanche',
                        ];
                
                        return $days[$state] ?? $state; // Retourne le jour ou la valeur brute si non trouvée
                    })
                    ->visible(fn($record) => $record && !is_null($record->recurrence)),
                
                
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
