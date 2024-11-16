<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultancyreportsResource\Pages;
use App\Filament\Resources\ConsultancyreportsResource\RelationManagers;
use App\Models\Consultancyreports;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultancyreportsResource extends Resource
{
    protected static ?string $model = Consultancyreports::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListConsultancyreports::route('/'),
            'create' => Pages\CreateConsultancyreports::route('/create'),
            'edit' => Pages\EditConsultancyreports::route('/{record}/edit'),
        ];
    }
}
