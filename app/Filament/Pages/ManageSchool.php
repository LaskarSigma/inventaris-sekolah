<?php

namespace App\Filament\Pages;

use app\Settings\SchoolSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSchool extends SettingsPage
{
    protected static ?string $navigationLabel = 'Pengaturan Sekolah';

    protected static ?string $title = 'Pengaturan Sekolah';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Cog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    protected static string $settings = SchoolSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('headmaster_name')
                    ->label('Kepala Sekolah')
                    ->required()
                    ->maxLength(255),
                TextInput::make('infrastructure_head_name')
                    ->required()
                    ->label('Waka Sarana Prasarana')
                    ->required()
                    ->maxLength(255),
            ])->columns(1);
    }
}
