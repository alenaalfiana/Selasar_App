<?php

namespace App\Filament\Resources\Presensis\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PresensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tiket_id')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\Placeholder::make('user_nama')
                    ->label('Nama Peserta')
                    ->content(fn ($record) => $record?->tiket?->pembayaran?->pendaftaran?->user?->nama ?? '-'),
                \Filament\Forms\Components\Placeholder::make('event_judul')
                    ->label('Judul Event')
                    ->content(fn ($record) => $record?->tiket?->pembayaran?->pendaftaran?->event?->judul ?? '-'),
                TextInput::make('qr_scan_code')
                    ->required(),
                Select::make('status')
                    ->options(['hadir' => 'Hadir', 'belum hadir' => 'Belum hadir'])
                    ->default('belum hadir')
                    ->required(),
                DateTimePicker::make('waktu_scan'),
            ]);
    }
}
