<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pendaftaran_id')
                    ->required()
                    ->numeric(),
                TextInput::make('foto_bukti_pembayaran')
                    ->default(null),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'valid' => 'Valid', 'ditolak' => 'Ditolak'])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('waktu_bayar'),
            ]);
    }
}
