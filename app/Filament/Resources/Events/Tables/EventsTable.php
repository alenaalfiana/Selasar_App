<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('foto_banner_event')
                    ->disk('public')
                    ->label('Banner'),
                TextColumn::make('kategori.nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jenis.nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_pelaksanaan')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('tanggal_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('kehadiran')
                    ->label('Kehadiran (Hadir / Kapasitas)')
                    ->getStateUsing(function (\App\Models\Event $record) {
                        $totalHadir = \App\Models\Presensi::whereHas('tiket.pembayaran.pendaftaran', function($q) use ($record) {
                            $q->where('event_id', $record->id);
                        })->where('status', 'hadir')->count();
                        return "{$totalHadir} / {$record->kapasitas}";
                    }),
                TextColumn::make('nama_rekening')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_rekening_bank')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
