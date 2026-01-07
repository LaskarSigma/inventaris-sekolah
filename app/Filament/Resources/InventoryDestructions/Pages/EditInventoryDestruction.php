<?php

namespace App\Filament\Resources\InventoryDestructions\Pages;

use App\Filament\Resources\InventoryDestructions\InventoryDestructionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryDestruction extends EditRecord
{
    protected static string $resource = InventoryDestructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
