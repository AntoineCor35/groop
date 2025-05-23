<?php

namespace App\Filament\Resources\EntitiesResource\Pages;

use App\Filament\Resources\EntitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntities extends EditRecord
{
    protected static string $resource = EntitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
