<?php

namespace App\Filament\Resources\InventoryDestructions\Pages;

use App\Filament\Resources\InventoryDestructions\InventoryDestructionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryDestructions extends ListRecords
{
    protected static string $resource = InventoryDestructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
