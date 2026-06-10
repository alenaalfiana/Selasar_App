<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Jenis;
use App\Models\Kategori;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['kategori', 'jenis']);

        if ($request->filled('jenis')) {
            $query->where('jenis_id', $request->jenis);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $events = $query
            ->latest('tanggal_pelaksanaan')
            ->get();

        $jenises = Jenis::all();
        $kategoris = Kategori::all();

        return view('frontend.index', compact(
            'events',
            'jenises',
            'kategoris'
        ));
    }

    public function show(Event $event)
    {
        return view('frontend.show', compact('event'));
    }
}