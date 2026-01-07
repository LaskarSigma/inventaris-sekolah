<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_address')
                    ->label('Nama dan Alamat Toko')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                DatePicker::make('entry_date')
                    ->label('Tanggal Masuk Barang')
                    ->required()
                    ->default(now())
                    ->displayFormat('d M Y')
                    ->maxDate(now())
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('receipt_date', $state);
                    })
                    ->native(false),
                DatePicker::make('receipt_date')
                    ->label('Tanggal Pembelian')
                    ->required()
                    ->default(now())
                    ->displayFormat('d M Y')
                    ->maxDate(now())
                    ->native(false),
                TextInput::make('brand')
                    ->label('Merek')
                    ->required()
                    ->maxLength(100),
                TextInput::make('name')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),
                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(999999)
                    ->default(1)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $unitPrice = $get('unit_price') ?? 0;
                        $set('total_price', $state * $unitPrice);
                    })
                    ->disabled(fn (?Model $record) => $record !== null)
                    ->dehydrated(),
                TextInput::make('unit_price')
                    ->label('Harga Satuan')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999999)
                    ->prefix('Rp')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $quantity = $get('quantity') ?? 0;
                        $set('total_price', $state * $quantity);
                    })
                    ->disabled(fn (?Model $record) => $record !== null)
                    ->dehydrated(),
                TextInput::make('total_price')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(),
                Select::make('funding')
                    ->label('Sumber Dana')
                    ->required()
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
                    ->native(false),
                Select::make('inventory_code_id')
                    ->label('Jenis Barang')
                    ->relationship('inventoryCode', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('code')
                            ->label('Kode')
                            ->required()
                            ->maxLength(50)
                            ->unique(),
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                    ]),
                FileUpload::make('photo')
                    ->label('Foto Barang')
                    ->image()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory('items')
                    ->visibility('public')
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }
}
