<?php

namespace App\Filament\Resources\InventoryDestructions\Tables;

use App\Filament\Actions\ViewNewsAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryDestructionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('destruction_date')
                    ->label('Tanggal Pemusnahan')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('inventoryStock.inventory_code')
                    ->label('Jenis Barang')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('inventoryStock.item.brand')
                    ->label('Merek')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('inventoryStock.item.name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 40 ? $state : null;
                    }),
                TextColumn::make('reason')
                    ->label('Alasan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Rusak Berat' => 'danger',
                        'Tidak Layak Pakai' => 'warning',
                        'Aus' => 'gray',
                        'Hilang' => 'danger',
                        'Usang' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewNewsAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
