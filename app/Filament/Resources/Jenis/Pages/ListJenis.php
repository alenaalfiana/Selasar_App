<?php

namespace App\Filament\Resources\Jenis\Pages;

use App\Filament\Resources\Jenis\JenisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenis extends ListRecords
{
    protected static string $resource = JenisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
