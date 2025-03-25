<?php

namespace App\Filament\Resources\ProjectLinksResource\Pages;

use App\Filament\Resources\ProjectLinksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectLinks extends EditRecord
{
    protected static string $resource = ProjectLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
