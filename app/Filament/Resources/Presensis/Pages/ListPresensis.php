<?php

namespace App\Filament\Resources\Presensis\Pages;

use App\Filament\Resources\Presensis\PresensiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('scan_qr')
                ->label('Scan QR Presensi')
                ->icon('heroicon-o-qr-code')
                ->color('success')
                ->url(fn () => PresensiResource::getUrl('scan')),
            CreateAction::make(),
        ];
    }
}
