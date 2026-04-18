<?php

namespace App\Filament\Resources\Penjualans;

use App\Filament\Resources\Penjualans\Pages\CreatePenjualan;
use App\Filament\Resources\Penjualans\Pages\EditPenjualan;
use App\Filament\Resources\Penjualans\Pages\ListPenjualans;
use App\Filament\Resources\Penjualans\Schemas\PenjualanForm;
use App\Filament\Resources\Penjualans\Tables\PenjualansTable;
use App\Models\Penjualan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocument;

    protected static ?string $recordTitleAttribute = 'penjualan_kode';

    protected static ?string $navigationLabel = "Penjualan";

    protected static ?int $navigationSort = 6;

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    public static function form(Schema $schema): Schema
    {
        $record = null;
        if (function_exists('request') && request()->route('record')) {
            $record = Penjualan::find(request()->route('record'));
        }
        return PenjualanForm::configure($schema, $record);
    }

    public static function table(Table $table): Table
    {
        return PenjualansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenjualans::route('/'),
            'create' => CreatePenjualan::route('/create'),
            'edit' => EditPenjualan::route('/{record}/edit'),
        ];
    }
}
