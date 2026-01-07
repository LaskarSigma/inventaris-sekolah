<?php

namespace App\Filament\Resources\InventoryStocks\Tables;

use App\Filament\Actions\BulkMoveInventoryAction;
use App\Filament\Actions\MoveInventoryAction;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereDoesntHave('destruction'))
            ->columns([
                TextColumn::make('item.receipt_date')
                    ->label('Tanggal Pembelian')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('item.receipt_no')
                    ->label('No. Pembelian')
                    ->searchable()
                    ->toggleable()
                    ->wrapHeader(),
                TextColumn::make('item.brand')
                    ->label('Merek')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 20 ? $state : null;
                    })
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('item.name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 30 ? $state : null;
                    })
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('inventory_code')
                    ->label('Kode Barang')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('incoming_stock')
                    ->label('Barang Masuk')
                    ->numeric()
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('outgoing_stock')
                    ->label('Barang Keluar')
                    ->numeric()
                    ->badge()
                    ->color('danger')
                    ->sortable()
                    ->wrapHeader(),
                TextColumn::make('location')
                    ->label('Tempat')
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('item.inventory_code_category')
                    ->label('Kelompok Barang')
                    ->options([
                        'A' => 'AXT',
                        'B' => 'Mebeulair',
                        'C' => 'Elektronik',
                        'D' => 'Mekanik',
                        'E' => 'Alat Rumah Tangga',
                        'F' => 'Pendukung KBM',
                    ])
                    ->multiple()
                    ->query(function (Builder $query, array $data): Builder {
                        $values = $data['values'] ?? [];

                        if (empty($values)) {
                            return $query;
                        }

                        return $query->whereHas('item.inventoryCode', function (Builder $query) use ($values) {
                            $query->where(function (Builder $query) use ($values) {
                                foreach ($values as $prefix) {
                                    $query->orWhere('code', 'LIKE', $prefix.'%');
                                }
                            });
                        });
                    }),
                SelectFilter::make('item.inventory_code_id')
                    ->label('Jenis Barang')
                    ->relationship('item.inventoryCode', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                Filter::make('item.brand')
                    ->label('Merk')
                    ->schema([
                        TextInput::make('brand')
                            ->label('Cari Merk')
                            ->placeholder('Contoh: Samsung, LG, dll'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['brand'],
                            fn (Builder $query, $brand): Builder => $query->whereHas('item', function (Builder $query) use ($brand) {
                                $query->where('brand', 'LIKE', "%{$brand}%");
                            })
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['brand']) {
                            return null;
                        }

                        return 'Merk: '.$data['brand'];
                    }),
                Filter::make('receipt_date')
                    ->schema([
                        DatePicker::make('receipt_date_from')
                            ->label('Dari Tanggal')
                            ->native(false)
                            ->displayFormat('d M Y'),
                        DatePicker::make('receipt_date_to')
                            ->label('Sampai Tanggal')
                            ->native(false)
                            ->displayFormat('d M Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['receipt_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereHas('item', function (Builder $query) use ($date) {
                                    $query->whereDate('receipt_date', '>=', $date);
                                }),
                            )
                            ->when(
                                $data['receipt_date_to'],
                                fn (Builder $query, $date): Builder => $query->whereHas('item', function (Builder $query) use ($date) {
                                    $query->whereDate('receipt_date', '<=', $date);
                                }),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['receipt_date_from'] ?? null) {
                            $indicators[] = 'Dari: '.Carbon::parse($data['receipt_date_from'])->format('d M Y');
                        }

                        if ($data['receipt_date_to'] ?? null) {
                            $indicators[] = 'Sampai: '.Carbon::parse($data['receipt_date_to'])->format('d M Y');
                        }

                        return $indicators;
                    }),
                SelectFilter::make('item.funding')
                    ->label('Sumber Dana')
                    ->options([
                        'BPOPP 1' => 'BPOPP 1',
                        'BPOPP 2' => 'BPOPP 2',
                        'BPOPP 3' => 'BPOPP 3',
                        'BPOPP 4' => 'BPOPP 4',
                        'BPOPP 5' => 'BPOPP 5',
                        'BOSP 1' => 'BOSP 1',
                        'BOSP 2' => 'BOSP 2',
                        'BOSP 3' => 'BOSP 3',
                        'BOSP 4' => 'BOSP 4',
                        'BOSP 5' => 'BOSP 5',
                        'Komite' => 'Komite',
                        'Bantuan pusat' => 'Bantuan pusat',
                        'Lain-lain' => 'Lain-lain',
                    ])
                    ->multiple()
                    ->query(function (Builder $query, array $data): Builder {
                        $values = $data['values'] ?? [];

                        if (empty($values)) {
                            return $query;
                        }

                        return $query->whereHas('item', function (Builder $query) use ($values) {
                            $query->whereIn('funding', $values);
                        });
                    }),
            ])
            ->recordActions([
                // EditAction::make(),
                // DeleteAction::make(),
                MoveInventoryAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //     DeleteBulkAction::make(),
                    BulkMoveInventoryAction::make(),
                ]),
            ]);
        // ->defaultSort('item.receipt_date', 'asc');
    }
}
