<?php

namespace App\Filament\Resources\InventoryDestructions\Schemas;

use App\Models\InventoryStock;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class InventoryDestructionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('inventory_stock_id')
                    ->label('Barang')
                    ->relationship(
                        name: 'inventoryStock',
                        titleAttribute: 'inventory_code',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->with(['item.inventoryCode'])
                            ->whereDoesntHave('destruction')
                            ->where('incoming_stock', '>', 0)
                    )
                    ->getOptionLabelFromRecordUsing(fn (InventoryStock $record) => "{$record->inventory_code} - {$record->item->name}"
                    )
                    ->searchable(['inventory_code'])
                    ->preload()
                    ->required()
                    ->live()
                    ->columnSpanFull(),

                DatePicker::make('destruction_date')
                    ->label('Tanggal Pemusnahan')
                    ->required()
                    ->default(now())
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->maxDate(now()),

                Select::make('reason')
                    ->label('Alasan Pemusnahan')
                    ->options([
                        'Rusak Berat' => 'Rusak Berat',
                        'Tidak Layak Pakai' => 'Tidak Layak Pakai',
                        'Aus' => 'Aus',
                        'Hilang' => 'Hilang',
                        'Usang' => 'Usang',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->native(false),

                FileUpload::make('news')
                    ->label('Berita Acara Pemusnahan')
                    ->required()
                    ->disk('public')
                    ->directory('news')
                    ->visibility('public')
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
