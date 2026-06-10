<?php

namespace App\Filament\Resources\Pembayarans\Pages;

use App\Filament\Resources\Pembayarans\PembayaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $pembayaran = $this->record;

        if ($pembayaran->status === 'valid') {
            $user = $pembayaran->pendaftaran->user;

            if ($user) {
                // If a ticket is created implicitly or already exists, we link it, 
                // but the user dashboard just redirects to dashboard where ticket can be seen.
                \Filament\Notifications\Notification::make()
                    ->title('Pembayaran telah diterima! Klik untuk mengambil tiket.')
                    ->success()
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('Lihat Tiket')
                            ->button()
                            ->url(route('dashboard')) // Or if route tickets.show is directly accessible, use it
                    ])
                    ->sendToDatabase($user);
            }
        }
    }
}
