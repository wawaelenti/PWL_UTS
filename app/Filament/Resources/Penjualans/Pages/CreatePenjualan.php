<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use App\Models\Penjualan;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate kode penjualan otomatis
        $lastPenjualan = Penjualan::latest('penjualan_id')->first();
        $nextNumber = ($lastPenjualan?->penjualan_id ?? 0) + 1;
        $data['penjualan_kode'] = 'TX-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Set user_id ke kasir
        $kasirUser = User::whereHas('level', function ($query) {
            $query->where('level_kode', 'KSR');
        })->first();
        $data['user_id'] = $kasirUser?->user_id;

        return $data;
    }
}
