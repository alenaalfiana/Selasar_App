<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Tiket $tiket)
    {
        // Ensure user owns this ticket
        if ($tiket->pembayaran->pendaftaran->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.ticket', compact('tiket'));
    }
}
