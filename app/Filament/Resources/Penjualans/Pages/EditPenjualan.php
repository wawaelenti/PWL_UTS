<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenjualan extends EditRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Set user_id ke kasir
        $kasirUser = User::whereHas('level', function ($query) {
            $query->where('level_kode', 'KSR');
        })->first();
        $data['user_id'] = $kasirUser?->user_id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
