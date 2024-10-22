<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistResource\Pages;
use App\Models\Checklist;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Title'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required(),
                Forms\Components\Select::make('created_by')
                    ->relationship('user', 'name')
                    ->label('Created By')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
        ->columns([
            TextColumn::make('title')
                ->label('Title')
                ->formatStateUsing(fn (string $state): string => strtoupper($state)), // Majuscule pour le titre
        ])
        ->actions([
            Action::make('view')
                ->label('View Details')
                ->icon('heroicon-o-eye')
                ->action(fn (Checklist $record) => [
                    'type' => 'alert',
                    'message' => "Title: {$record->title}\nDescription: {$record->description}\nCreated By: {$record->user->name}", // Détails de la checklist
                ])
                ->modalHeading('Checklist Details') // Titre de l'alerte (si vous utilisez un modal plutôt qu'une alerte)
                ->modalContent(fn (Checklist $record) => view('your-view-name', ['record' => $record])), // Utilisez un modal avec un contenu
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn (Checklist $record): string => ChecklistResource::getUrl('edit', ['record' => $record->getKey()])), // Lien vers la page d'édition
            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->action(fn (Checklist $record) => $record->delete()) // Action de suppression
                ->requiresConfirmation(), // Demande de confirmation avant suppression
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecklists::route('/'),
            'create' => Pages\CreateChecklist::route('/create'),
            'edit' => Pages\EditChecklist::route('/{record}/edit'),
            'view' => Pages\ViewChecklist::route('/{record}'), // Route pour voir les détails
        ];
    }
}
