<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\TaskResource\Pages;
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
                        $set('name_employee', $checklist->employee->username ?? null);
                    }),

                Forms\Components\TextInput::make('name_employee')
                    ->label('Nom de l\'Employé')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\Textarea::make('task_details')
                    ->label('Détail de la Tâche (une tâche par ligne)')
                    ->rows(6)
                    ->required(),

                Forms\Components\Textarea::make('commentaire')
                    ->label('Bloquage')
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

                Tables\Columns\TextColumn::make('task_details')
                    ->label('Détail de la Tâche')
                    ->formatStateUsing(function ($state) {
                        $tasks = explode("\n", $state);
                        return collect($tasks)->map(function ($task) {
                            $trimmedTask = htmlspecialchars(trim($task));
                            return '<div>
                                <input type="checkbox" name="tasks[]" value="' . $trimmedTask . '" />
                                <label>' . $trimmedTask . '</label>
                            </div>';
                        })->implode('');
                    })
                    ->html(), // Assurez-vous d'utiliser html() ici

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

    // Méthode pour obtenir les options de tâche
    protected function getTaskOptions()
    {
        $tasks = explode("\n", $this->task_details);
        return collect($tasks)->mapWithKeys(function ($task) {
            return [htmlspecialchars(trim($task)) => htmlspecialchars(trim($task))];
        })->toArray();
    }
}
