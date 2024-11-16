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

                Forms\Components\DatePicker::make('date')
                    ->label('Date de la Tâche')
                    ->required(),
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
