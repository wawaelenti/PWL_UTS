<?php

namespace App\Filament\Resources\Stoks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;


class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->relationship('supplier', 'supplier_nama')
                    ->required()
                    ->preload()
                    ->searchable(),
                Select::make('barang_id')
                    ->relationship('barang', 'barang_nama')
                    ->required()
                    ->preload()
                    ->searchable(),
                Select::make('user_id')
                    ->relationship('user', 'nama')
                    ->required()
                    ->default(fn() => auth()->id())
                    ->disabled()
                    ->dehydrated(),
                DateTimePicker::make('stok_tanggal')
                    ->required(),
                TextInput::make('stok_jumlah')
                    ->required()
                    ->numeric(),
            ]);
    }
}
