<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang_kode')
                    ->searchable(),
                TextColumn::make('barang_nama')
                    ->searchable(),
                TextColumn::make('kategori.kategori_nama')
                    ->searchable(),
                TextColumn::make('harga_jual')
                    ->money('IDR', true)
                    ->label('Harga Jual'),
                TextColumn::make('harga_beli')
                    ->money('IDR', true)
                    ->label('Harga Beli'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
