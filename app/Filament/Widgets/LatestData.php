<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestData extends BaseWidget

{

    protected static ?int $sort = 4;


    public function table(Table $table): Table
    {
        return $table
            ->query()
            ->defaultPaginationPageOption(option :5)
            ->columns([
                // ...
            ]);
    }
}
