<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->square()
                    ->imageSize(50)
                    ->disk('public')
                    ->defaultImageUrl(asset('images/no-image.png')),
                TextColumn::make('entry_date')
                    ->label('Tanggal Masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('name_address')
                    ->label('Nama dan Alamat Toko')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 30 ? $state : null;
                    })
                    ->wrapHeader(),
                TextColumn::make('receipt_date')
                    ->label('Tanggal Pembelian')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('receipt_no')
                    ->label('No. Pembelian')
                    ->searchable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('brand')
                    ->label('Merek')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 20 ? $state : null;
                    })
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 30 ? $state : null;
                    })
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->wrapHeader()
                    ->sortable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('total_price')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('funding')
                    ->label('Sumber Dana')
                    ->wrapHeader()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'BPOPP 1', 'BPOPP 2', 'BPOPP 3', 'BPOPP 4', 'BPOPP 5' => 'success',
                        'BOSP 1', 'BOSP 2', 'BOSP 3', 'BOSP 4', 'BOSP 5' => 'info',
                        'Komite' => 'warning',
                        'Bantuan pusat' => 'primary',
                        'Lain-lain' => 'gray',
                    })
                    ->searchable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('inventoryCode.code')
                    ->label('Jenis Barang')
                    ->wrapHeader()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->wrapHeader(),
                // TextColumn::make('inventoryCode.name')
                //     ->label('Nama Inv.')
                //     ->wrapHeader()
                //     ->searchable()
                //     ->sortable()
                //     ->limit(10)
                //     ->tooltip(function (TextColumn $column): ?string {
                //         $state = $column->getState();

                //         return strlen($state) > 10 ? $state : null;
                //     })
                //     ->toggleable()
                //     ->wrapHeader(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('entry_date', 'desc');
    }
}
