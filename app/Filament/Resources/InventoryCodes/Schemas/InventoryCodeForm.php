<?php

namespace App\Filament\Resources\InventoryCodes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make(name: 'code')
                    ->label('Kode')
                    ->required()
                    ->minLength(3)
                    ->maxLength(3)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('code', strtoupper($state ?? '')))
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->label('Nama Jenis Baraang')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
