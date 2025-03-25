<?php

namespace App\Filament\Resources\ProjectLinksResource\Pages;

use App\Filament\Resources\ProjectLinksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectLinks extends ListRecords
{
    protected static string $resource = ProjectLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
