<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class MoveInventoryAction
{
    public static function make(): Action
    {
        return Action::make('moveInventoryStock')
            ->label('Pindah')
            ->icon('heroicon-o-arrow-right-circle')
            ->color('warning')
            ->schema([
                TextInput::make('new_location')
                    ->label('Pindah ke tempat')
                    ->required()
                    ->helperText('Pilih tempat tujuan untuk barang ini.'),
            ])
            ->action(function (array $data, $record): void {
                DB::transaction(function () use ($data, $record) {
                    $isReturningToMainWarehouse = $data['new_location'] === 'Gudang Bu Tias';

                    $record->update([
                        'location' => $data['new_location'],
                        'incoming_stock' => $isReturningToMainWarehouse ? 1 : 0,
                        'outgoing_stock' => $isReturningToMainWarehouse ? 0 : 1,
                    ]);
                });

                Notification::make()
                    ->success()
                    ->title('Barang berhasil dipindahkan')
                    ->body("Barang dipindah ke {$data['new_location']}")
                    ->send();
            })
            ->requiresConfirmation()
            ->modalHeading('Pindah Barang')
            ->modalDescription('Ini akan memindahkan barang ke lokasi baru.')
            ->modalSubmitActionLabel('Pindah');
    }
}
