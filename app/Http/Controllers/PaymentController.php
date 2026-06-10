<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class PaymentController extends Controller
{
    public function create(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($pendaftaran->pembayaran) {
            return redirect()->route('dashboard')->with('info', 'Pembayaran sudah diupload.');
        }

        return view('user.payment', compact('pendaftaran'));
    }

    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $isFree = $pendaftaran->event->harga == 0;
        
        if (!$isFree) {
            $request->validate([
                'foto_bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $path = $request->file('foto_bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $status = 'pending';
        } else {
            $path = null;
            $status = 'valid';
        }

        $pembayaran = Pembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'foto_bukti_pembayaran' => $path,
            'status' => $status,
            'waktu_bayar' => now(),
        ]);

        $kodeTiket = strtoupper(uniqid('TKT-'));

        if ($isFree) {
            \App\Models\Tiket::create([
                'pembayaran_id' => $pembayaran->id,
                'kode_tiket' => strtoupper(uniqid('TKT-')), 
                'qr_path' => $kodeTiket,
            ]);
            return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil. Tiket telah diterbitkan.');
        }

        // Send notification to admin
        $admins = \App\Models\User::where('role_as', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::make()
                ->title(
                    "Peserta dengan nama '" .
                        auth()->user()->nama .
                        "' telah membayar untuk event '" .
                        $pendaftaran->event->judul .
                        "'"
                )
                ->actions([
                    Action::make('validasi')
                        ->label('Validasi')
                        ->url('/admin/pembayarans/' . $pembayaran->id . '/edit')
                ])
                ->sendToDatabase($admin);
        }

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu validasi admin.');
    }
}
