<?php

namespace App\Filament\Resources\InventoryStocks\Pages;

use App\Filament\Resources\InventoryStocks\InventoryStockResource;
use App\Settings\SchoolSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryStocks extends ListRecords
{
    protected static string $resource = InventoryStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
            Action::make('exportInventoryStockPdf')
                ->label('Eksport PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function ($livewire) {
                    $records = $livewire->getFilteredTableQuery()->with(['item.inventoryCode'])->get();
                    $settings = app(SchoolSettings::class);

                    $tableFilters = $livewire->getTable()->getFilters();
                    $filterState = [];

                    foreach ($tableFilters as $filter) {
                        $filterState[$filter->getName()] = $filter->getState();
                    }

                    $categoryFilter = $filterState['item.inventory_code_category']['values'] ?? [];
                    $categoryMap = [
                        'A' => 'AXT',
                        'B' => 'Mebeulair',
                        'C' => 'Elektronik',
                        'D' => 'Mekanik',
                        'E' => 'Alat Rumah Tangga',
                        'F' => 'Pendukung KBM',
                    ];
                    $categoryNames = array_map(fn ($code) => $categoryMap[$code] ?? $code, $categoryFilter);
                    $category = ! empty($categoryNames) ? implode(', ', $categoryNames) : 'Semua Kelompok';

                    $inventoryCodeIds = $filterState['item.inventory_code_id']['values'] ?? [];
                    $inventoryCodeNames = [];
                    if (! empty($inventoryCodeIds)) {
                        $inventoryCodeNames = \App\Models\InventoryCode::whereIn('id', $inventoryCodeIds)
                            ->pluck('code')
                            ->toArray();
                    }
                    $inventoryCode = ! empty($inventoryCodeNames) ? implode(', ', $inventoryCodeNames) : 'Semua Jenis';

                    $brand = $filterState['item.brand']['brand'] ?? 'Semua Merk';

                    $dateFrom = $filterState['receipt_date']['receipt_date_from'] ?? null;
                    $dateTo = $filterState['receipt_date']['receipt_date_to'] ?? null;
                    $dateRange = 'Semua Tanggal';

                    if ($dateFrom && $dateTo) {
                        $dateRange = Carbon::parse($dateFrom)->format('d M Y').' - '.Carbon::parse($dateTo)->format('d M Y');
                    } elseif ($dateFrom) {
                        $dateRange = 'Dari '.Carbon::parse($dateFrom)->format('d M Y');
                    } elseif ($dateTo) {
                        $dateRange = 'Sampai '.Carbon::parse($dateTo)->format('d M Y');
                    }

                    $pdf = Pdf::loadView('pdf.inventory-stocks', [
                        'records' => $records,
                        'settings' => $settings,
                        'category' => $category,
                        'inventoryCode' => $inventoryCode,
                        'brand' => $brand,
                        'dateRange' => $dateRange,
                    ])->setPaper('a4', 'potrait');

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'kartu-persediaan-barang-'.now()->format('Y-m-d').'.pdf');
                }),
        ];
    }
}
