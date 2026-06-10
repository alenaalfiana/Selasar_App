<?php

namespace App\Filament\Resources\Pendaftarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PendaftaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('event_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('waktu_daftar')
                    ->required(),
            ]);
    }
}
