<?php

namespace App\Filament\Resources\Tikets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TiketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pembayaran_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kode_tiket')
                    ->required(),
                TextInput::make('qr_path')
                    ->required(),
            ]);
    }
}
