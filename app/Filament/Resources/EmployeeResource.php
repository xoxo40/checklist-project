<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Employee Management';

    // Formulaire pour ajouter/modifier un employé
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->rule('regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateEmployee) // Le mot de passe est obligatoire seulement lors de la création
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)) // Hash du mot de passe lors de la soumission
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateEmployee), // Visible seulement à la création

                // Champ texte pour 'role'
                Forms\Components\TextInput::make('role')
                    ->label('Role')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    // Table pour afficher les employés
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(), // Action d'édition
                Tables\Actions\DeleteAction::make(), // Action de suppression individuelle
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Action de suppression en lot
            ]);
    }

    // Relations (si nécessaire)
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Pages du CRUD (index, créer, éditer)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
