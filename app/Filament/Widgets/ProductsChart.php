<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{

    protected static ?int $sort = 3;
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [

            'datasets'=>[

                [
                    
                    'label ' =>'Todays data',
                    'data' => [0,4,5,6,4,3,4,5,3,3]
                    ]
            
                ],

                'labels'=>['Lun','Mar','Mer','Jeu','Ven']
            
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
