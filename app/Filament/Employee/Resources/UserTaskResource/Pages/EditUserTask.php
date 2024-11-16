<?php

namespace App\Filament\Employee\Resources\UserTaskResource\Pages;

use App\Filament\Employee\Resources\UserTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserTask extends EditRecord
{
    protected static string $resource = UserTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
