<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $existing = Pendaftaran::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah terdaftar di event ini.');
        }

        // Check capacity - exclude registrations that have rejected payments
        $registeredCount = Pendaftaran::where('event_id', $event->id)
            ->whereDoesntHave('pembayaran', function ($query) {
                $query->where('status', 'ditolak');
            })
            ->count();

        if ($registeredCount >= $event->kapasitas) {
            return back()->with('error', 'Kapasitas event sudah penuh.');
        }

        $pendaftaran = Pendaftaran::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'waktu_daftar' => now(),
        ]);

        $sisaKuota = $event->kapasitas - ($registeredCount + 1);

        // Send notification to admin
        $admins = \App\Models\User::where('role_as', 'admin')->get();
        foreach ($admins as $admin) {
            \Filament\Notifications\Notification::make()
                ->title('Ada peserta yang mendaftar! Kuota sisa ' . $sisaKuota)
                ->sendToDatabase($admin);
        }

        return redirect()->route('payments.create', $pendaftaran)->with('success', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
    }
}
