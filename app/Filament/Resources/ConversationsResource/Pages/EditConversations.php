<?php

namespace App\Filament\Resources\ConversationsResource\Pages;

use App\Filament\Resources\ConversationsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConversations extends EditRecord
{
    protected static string $resource = ConversationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
