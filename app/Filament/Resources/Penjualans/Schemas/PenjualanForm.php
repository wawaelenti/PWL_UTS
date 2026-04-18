<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use App\Models\Barang;
use App\Models\PenjualanDetail;
use App\Models\Stok;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class PenjualanForm
{
    public static function configure(Schema $schema, $record = null): Schema
    {
        $kasirUser = User::whereHas('level', function ($query) {
            $query->where('level_kode', 'KSR');
        })->first();

        $penjualanId = $record?->penjualan_id;

        return $schema
            ->components([
                Hidden::make('penjualan_kode'),
                DateTimePicker::make('penjualan_tanggal')
                    ->required(),
                TextInput::make('pembeli')
                    ->nullable(),
                Select::make('user_id')
                    ->label('User/Penjual')
                    ->options(User::all()->pluck('nama', 'user_id'))
                    ->afterStateHydrated(function ($state, $set) use ($kasirUser) {
                        if (!$state) {
                            $set('user_id', $kasirUser?->user_id);
                        }
                    })
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                ComponentsSection::make('Detail Barang')
                    ->schema([
                        Repeater::make('details')
                            ->relationship('details')
                            ->schema([
                                Select::make('barang_id')
                                    ->label('Barang')
                                    ->options(Barang::all()->pluck('barang_nama', 'barang_id'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $barang = Barang::find($state);
                                        if ($barang) {
                                            $set('harga', $barang->harga_jual);
                                        }
                                    }),
                                TextInput::make('jumlah')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->live()
                                    ->helperText(function ($get) use ($penjualanId) {
                                        $barangId = $get('barang_id');
                                        if (!$barangId) {
                                            return 'Pilih barang terlebih dahulu';
                                        }
                                        $stokJumlah = Stok::where('barang_id', $barangId)->sum('stok_jumlah');
                                        $terjualJumlah = PenjualanDetail::where('barang_id', $barangId)
                                            ->when($penjualanId, function ($query) use ($penjualanId) {
                                                $query->where('penjualan_id', '!=', $penjualanId);
                                            })
                                            ->sum('jumlah');
                                        $sisaStok = $stokJumlah - $terjualJumlah;
                                        return "Sisa stok: {$sisaStok}";
                                    })
                                    ->maxValue(function ($get) use ($penjualanId) {
                                        $barangId = $get('barang_id');
                                        if (!$barangId) {
                                            return 0;
                                        }
                                        $stokJumlah = Stok::where('barang_id', $barangId)->sum('stok_jumlah');
                                        $terjualJumlah = PenjualanDetail::where('barang_id', $barangId)
                                            ->when($penjualanId, function ($query) use ($penjualanId) {
                                                $query->where('penjualan_id', '!=', $penjualanId);
                                            })
                                            ->sum('jumlah');
                                        $sisaStok = $stokJumlah - $terjualJumlah;
                                        return max(0, $sisaStok);
                                    })
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $barang = Barang::find($get('barang_id'));
                                        if ($barang) {
                                            $set('harga', $barang->harga_jual * $state);
                                        }
                                    }),
                                TextInput::make('harga')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                            ->addActionLabel('Tambah Barang')
                            ->defaultItems(1),
                    ]),
            ]);
    }
}
