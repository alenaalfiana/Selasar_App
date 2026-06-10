<?php

namespace App\Filament\Resources\Jenis\Pages;

use App\Filament\Resources\Jenis\JenisResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJenis extends CreateRecord
{
    protected static string $resource = JenisResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
