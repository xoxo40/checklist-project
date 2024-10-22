<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;  // Importation correcte des classes
use Filament\Resources\Resource;
use Filament\Resources\Form; // Utilisation correcte de la classe Form dans Filament
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    // Correction de la signature de la méthode `form` en utilisant Filament\Forms\Form
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('checklist_description')
                    ->label('Titre de la Tâche')
                    ->required(),

                Forms\Components\Textarea::make('checklist_details')
                    ->label('Description des tâches (saisir chaque tâche avec "- " au début)')
                    ->rows(6)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('checklist_description')
                    ->label('Titre de la Tâche')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('checklist_details')
                    ->label('Description des Tâches')
                    ->formatStateUsing(function ($state) {
                        // Format la description sous forme de liste (pour l'admin)
                        $tasks = explode("\n", $state);
                        $formattedTasks = collect($tasks)->map(function ($task) {
                            if (Str::startsWith(trim($task), '- ')) {
                                return '• ' . substr(trim($task), 2); // Remplace "- " par "• "
                            }
                            return $task;
                        });

                        return implode("<br>", $formattedTasks->toArray());
                    })
                    ->html(),
            ])
            ->filters([
                // Vous pouvez ajouter des filtres ici si nécessaire
            ])
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
            'create' => Pages\CreateTasks::route('/create'),
            'edit' => Pages\EditTasks::route('/{record}/edit'),
            'view' => Pages\ViewTasks::route('/{record}/view'),
        ];
    }
}
