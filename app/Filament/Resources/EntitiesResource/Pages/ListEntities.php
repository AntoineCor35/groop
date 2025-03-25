<?php

namespace App\Filament\Resources\EntitiesResource\Pages;

use App\Filament\Resources\EntitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntities extends ListRecords
{
    protected static string $resource = EntitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
