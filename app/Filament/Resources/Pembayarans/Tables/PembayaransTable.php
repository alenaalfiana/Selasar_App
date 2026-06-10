<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
// use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pendaftaran.user.nama')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pendaftaran.event.judul')
                    ->label('Event')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\ImageColumn::make('foto_bukti_pembayaran')
                    ->label('Bukti'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'valid' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('waktu_bayar')
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
                Action::make('validasi')
                    ->label('Validasi')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (\App\Models\Pembayaran $record) => $record->status === 'pending')
                    ->action(fn (\App\Models\Pembayaran $record) => $record->update(['status' => 'valid'])),
                Action::make('tolak')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn (\App\Models\Pembayaran $record) => $record->status === 'pending')
                    ->action(fn (\App\Models\Pembayaran $record) => $record->update(['status' => 'ditolak'])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
