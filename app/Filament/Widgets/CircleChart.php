<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class CircleChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [

            

            'labels' => ['Terminé','En cours','Commencé'],
            'datasets'=>[ 
                [
                'label'=>'statistiques des tâches',
                'data' =>[30,50,20],
            'backgroundColor' => [
                'rgba(75,192,0.2)',
                'rgba(255,206,86,0.2)',
                'rgba(255,99,132,0.2)'
            ],
            'borderColor' => [
                'rgba(75,192,192,1)',
                'rgba(255,206,86,1)',
                'rgba(255,99,132,1)'
            
            ],
            'borderWidth'=>1,
                ]
                
        ],
            ];
            



           
            
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
