<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('kategori_id')
                    ->relationship('kategori', 'nama')
                    ->required(),
                \Filament\Forms\Components\Select::make('jenis_id')
                    ->relationship('jenis', 'nama')
                    ->required(),
                TextInput::make('judul')
                    ->required()
                    ->maxLength(150),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('lokasi')
                    ->required()
                    ->maxLength(150),
                TextInput::make('kapasitas')
                    ->required()
                    ->numeric(),
                TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('tanggal_pelaksanaan')
                    ->required(),
                DateTimePicker::make('tanggal_selesai')
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('foto_banner_event')
                    ->image()
                    ->directory('banners')
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpanFull(),
                TextInput::make('nama_rekening')
                    ->maxLength(150),
                TextInput::make('nama_rekening_bank')
                    ->maxLength(150),
                TextInput::make('no_rekening_pembayaran')
                    ->maxLength(50),
            ]);
    }
}
