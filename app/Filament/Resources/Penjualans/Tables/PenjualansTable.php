<?php

namespace App\Filament\Resources\Penjualans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penjualan_kode')
                    ->searchable()
                    ->label('Kode Penjualan'),
                TextColumn::make('pembeli')
                    ->searchable(),
                TextColumn::make('details.barang.barang_nama')
                    ->label('Barang')
                    ->bulleted()
                    ->searchable(),
                TextColumn::make('details.jumlah')
                    ->label('Jumlah')
                    ->bulleted(),
                TextColumn::make('details.harga')
                    ->label('Harga')
                    ->bulleted()
                    ->money('IDR'),
                TextColumn::make('penjualan_tanggal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
