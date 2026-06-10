<?php

namespace App\Filament\Resources\Presensis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PresensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tiket_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tiket.pembayaran.pendaftaran.user.nama')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tiket.pembayaran.pendaftaran.event.judul')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('qr_scan_code')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('waktu_scan')
                    ->dateTime()
                    ->sortable(),
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
