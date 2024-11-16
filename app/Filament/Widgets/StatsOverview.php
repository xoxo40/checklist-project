<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';


    protected static bool $islazy = true;

    protected function getStats(): array
    {
        return [
            stat::make(label:'Total Checklists',value :'10k')
            ->description(description: 'Increase in Checklists')
            
            ->color(color: 'success')
            ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            stat::make(label:'Task in progres', value:'30%')
            ->description(description:'Taux Task in progres')
            ->color(color:'danger')
            ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            stat::make(label:'Task Finish', value:'70%')
            ->description(description:'Taux Task Finish')
            ->color(color:'danger')
            ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
