<?php

namespace App\Filament\Resources\Pendaftarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PendaftaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('event.judul')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('waktu_daftar')
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
            // ->recordActions([
            //     \Filament\Tables\Actions\Action::make('setujui')
            //         ->label('Setujui')
            //         ->color('success')
            //         ->icon('heroicon-o-check')
            //         ->visible(fn (\App\Models\Pendaftaran $record) => $record->status === 'menunggu')
            //         ->action(fn (\App\Models\Pendaftaran $record) => $record->update(['status' => 'disetujui'])),
            //     \Filament\Tables\Actions\Action::make('tolak')
            //         ->label('Tolak')
            //         ->color('danger')
            //         ->icon('heroicon-o-x-mark')
            //         ->visible(fn (\App\Models\Pendaftaran $record) => $record->status === 'menunggu')
            //         ->action(fn (\App\Models\Pendaftaran $record) => $record->update(['status' => 'ditolak'])),
            // ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
