<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $pendaftarans = auth()->user()->pendaftarans()->with('event.kategori', 'event.jenis', 'pembayaran.tiket')->get();
        
        $registeredEventIds = $pendaftarans->pluck('event_id')->toArray();
        
        $upcomingEvents = \App\Models\Event::with('kategori', 'jenis')
            ->whereNotIn('id', $registeredEventIds)
            ->latest('tanggal_pelaksanaan')
            ->get();

        return view('user.dashboard', compact('pendaftarans', 'upcomingEvents'));
    }
}
