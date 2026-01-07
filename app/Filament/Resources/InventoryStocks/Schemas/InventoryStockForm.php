<?php

namespace App\Filament\Resources\InventoryStocks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('inventory_code')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('incoming_stock')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('outgoing_stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->default('Gudang Bu Tias'),
            ]);
    }
}
