<?php

namespace App\Filament\Resources\Presensis\Pages;

use App\Filament\Resources\Presensis\PresensiResource;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Tiket;
use App\Models\Presensi;

class ScanQr extends Page
{
    protected static string $resource = PresensiResource::class;

    protected string $view = 'filament.resources.presensis.pages.scan-qr';

    public function processScan($kode_tiket)
    {
        $tiket = Tiket::where('kode_tiket', $kode_tiket)->first();
        if (!$tiket) {
            Notification::make()->title('Tiket Tidak Ditemukan!')->danger()->send();
            return;
        }

        $presensi = Presensi::where('tiket_id', $tiket->id)->first();
        if ($presensi) {
            Notification::make()->title('Peserta Sudah Check-in Sebelumnya!')->warning()->send();
            return;
        }

        Presensi::create([
            'tiket_id' => $tiket->id,
            'qr_scan_code' => $kode_tiket,
            'status' => 'hadir',
            'waktu_scan' => now(),
        ]);

        Notification::make()->title('Check-in Berhasil!')->success()->send();
        $this->redirect(PresensiResource::getUrl('index'));
    }
}
