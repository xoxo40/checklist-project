<?php

namespace App\Filament\Resources\ConsultancyreportsResource\Pages;

use App\Filament\Resources\ConsultancyreportsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultancyreports extends ListRecords
{
    protected static string $resource = ConsultancyreportsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
