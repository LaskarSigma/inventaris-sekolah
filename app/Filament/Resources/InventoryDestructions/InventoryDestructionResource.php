<?php

namespace App\Filament\Resources\InventoryDestructions;

use App\Filament\Resources\InventoryDestructions\Pages\CreateInventoryDestruction;
use App\Filament\Resources\InventoryDestructions\Pages\EditInventoryDestruction;
use App\Filament\Resources\InventoryDestructions\Pages\ListInventoryDestructions;
use App\Filament\Resources\InventoryDestructions\Schemas\InventoryDestructionForm;
use App\Filament\Resources\InventoryDestructions\Tables\InventoryDestructionsTable;
use App\Models\InventoryDestruction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InventoryDestructionResource extends Resource
{
    protected static ?string $model = InventoryDestruction::class;

    protected static ?string $navigationLabel = 'Pemusnahan Barang';

    protected static ?string $modelLabel = 'Pemusnahan Barang';

    protected static ?string $pluralModelLabel = 'Pemusnahan Barang';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxXMark;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::ArchiveBoxXMark;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return InventoryDestructionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryDestructionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventoryDestructions::route('/'),
            // 'create' => CreateInventoryDestruction::route('/create'),
            // 'edit' => EditInventoryDestruction::route('/{record}/edit'),
        ];
    }
}
