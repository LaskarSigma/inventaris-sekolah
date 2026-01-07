<?php

namespace App\Filament\Actions;

use App\Models\InventoryDestruction;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ViewNewsAction {
  public static function make(): Action
  {
    return Action::make('viewNews')
      ->label('Lihat Berita')
      ->icon('heroicon-o-document-text')
      ->color('info')
                    ->url(fn (InventoryDestruction $record): string =>
                        $record->news
                            ? asset("storage/{$record->news}")
                            : '#'
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (InventoryDestruction $record): bool =>
                        !empty($record->news)
                    );
  }
};