<?php

namespace App\Filament\Resources\Jenis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JenisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Jenis Event')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Webinar'),
            ]);
    }
}
