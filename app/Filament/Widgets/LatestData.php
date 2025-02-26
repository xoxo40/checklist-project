<?php

namespace App\Filament\Widgets;
use App\Models\UserTask;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;

class LatestData extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $maxWidth = '100%';
    protected static ?string $heading = "Dernières données de tâche ";
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                UserTask::query()
                    ->whereDate('date', Carbon::today())
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('task.checklist.description')
                ->label('Titre de tâche')
                    ->wrap()
                    ->limit(50)
                    ->grow(false),
                
                Tables\Columns\TextColumn::make('name_employee')
                ->label(" nom de l'mployé ")
                    ->wrap()
                    ->grow(false),
                
                Tables\Columns\BadgeColumn::make('is_completed')
                ->label('Statut')
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
                })
                    ->grow(false),
                
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->grow(false),
            ])
            ->filters([])
            ->contentGrid([
                'default' => 1,
            ])
            ->paginated([5])
            ;
    }

    public static function canView(): bool
    {
        return true;
    }
}