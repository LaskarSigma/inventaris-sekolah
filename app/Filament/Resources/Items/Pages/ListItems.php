<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportItemPdf')
                ->label('Eksport PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function ($livewire) {
                    $records = $livewire->getFilteredTableQuery()->get();

                    $pdf = Pdf::loadView('pdf.items', [
                        'records' => $records,
                    ])->setPaper('a4', 'landscape');

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'data-barang-'.now()->format('Y-m-d').'.pdf');
                }),
            CreateAction::make(),
        ];
    }
}
