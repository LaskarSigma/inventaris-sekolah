<?php

namespace App\Filament\Actions;

use Filament\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BulkMoveInventoryAction
{
    public static function make(): BulkAction
    {
        return BulkAction::make('bulkMoveInventoryStock')
            ->label('Pindah yang dipilih')
            ->icon('heroicon-o-arrow-right-circle')
            ->color('warning')
            ->schema([
                TextInput::make('new_location')
                    ->label('Pindah ke tempat')
                    ->required()
                    ->helperText('Pilih tempat tujuan untuk barang ini.'),
            ])
            ->action(function (Collection $records, array $data): void {
                $movedCount = 0;

                DB::transaction(function () use ($records, $data, &$movedCount) {
                    foreach ($records as $record) {
                        $isReturningToMainWarehouse = $data['new_location'] === 'Gudang Bu Tias';

                        $record->update([
                            'location' => $data['new_location'],
                            'incoming_stock' => $isReturningToMainWarehouse ? 1 : 0,
                            'outgoing_stock' => $isReturningToMainWarehouse ? 0 : 1,
                        ]);

                        $movedCount++;
                    }
                });

                Notification::make()
                    ->success()
                    ->title('Barang yang dipilih berhasil dipindahkan')
                    ->body("Barang dipindah ke {$data['new_location']}")
                    ->send();
            })
            ->requiresConfirmation()
            ->modalHeading('Pindah Barang yang dipilih')
            ->modalDescription('Ini akan memindahkan barang yang dipilih ke lokasi baru.')
            ->modalSubmitActionLabel('Pindah');
    }
}
