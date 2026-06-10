@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-8 max-w-container-max mx-auto w-full flex-grow">
    
    <!-- Alerts / Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-error-container border border-error/20 text-on-error-container rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-error">error</span>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 p-4 bg-secondary-container border border-outline-variant text-on-secondary-container rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <span class="font-medium">{{ session('info') }}</span>
        </div>
    @endif

    <!-- Hero / Welcome -->
<section class="mb-10 p-6 md:p-8 bg-primary-fixed text-on-primary-fixed rounded-2xl border border-primary/10 relative overflow-hidden">
    <div class="relative z-10 max-w-2xl">
        <h1 class="font-black text-2xl md:text-4xl mb-2 text-primary">
            Selamat Datang, {{ auth()->user()->nama }}!
        </h1>

        <p class="text-sm md:text-base text-on-primary-fixed-variant opacity-90 leading-relaxed">
            Temukan berbagai kegiatan kampus yang menarik dan kelola pendaftaran event Anda.
        </p>
    </div>

    <div class="absolute right-0 bottom-0 top-0 w-1/3 bg-gradient-to-l from-primary-fixed-dim/20 to-transparent pointer-events-none hidden md:block"></div>
</section>

    <!-- My Registered Events Section -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-bold text-2xl text-on-surface">Event yang Anda Ikuti</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($pendaftarans as $pendaftaran)
                @php
                    $event = $pendaftaran->event;
                    $pembayaran = $pendaftaran->pembayaran;
                @endphp
                <div onclick="if(!event.target.closest('a') && !event.target.closest('button')) window.location='{{ route('events.show', $event) }}';" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 flex gap-4 items-center shadow-sm hover:shadow-md hover:bg-surface-container-low cursor-pointer transition-all">
                    <!-- Date Badge -->
                    <div class="flex-shrink-0 w-16 h-16 bg-primary text-on-primary flex flex-col items-center justify-center rounded-lg shadow-sm">
                        <span class="text-[10px] font-bold uppercase tracking-wider leading-none">
                            {{ $event->tanggal_pelaksanaan->format('M') }}
                        </span>
                        <span class="text-2xl font-black leading-none mt-1">
                            {{ $event->tanggal_pelaksanaan->format('d') }}
                        </span>
                    </div>

                    <!-- Details & Status -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-base text-on-surface truncate mb-1">
                            {{ $event->judul }}
                        </h3>
                        <p class="text-xs text-secondary flex items-center gap-1 mb-2">
                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                            <span class="truncate">{{ $event->lokasi }}</span>
                        </p>

                        <!-- Action States -->
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            @php
                                $now = now();
                                $eventStatus = 'akan_datang';
                                if ($now >= $event->tanggal_pelaksanaan && $now <= $event->tanggal_selesai) {
                                    $eventStatus = 'berjalan';
                                } elseif ($now > $event->tanggal_selesai) {
                                    $eventStatus = 'selesai';
                                }
                            @endphp

                            @if($eventStatus === 'selesai')
                                <span class="bg-surface-container-high text-on-surface-variant px-2.5 py-0.5 rounded-full text-xs font-bold">Selesai</span>
                            @elseif($eventStatus === 'berjalan')
                                <span class="bg-primary/10 text-primary px-2.5 py-0.5 rounded-full text-xs font-bold border border-primary/20">Sedang Berjalan</span>
                            @endif

                            @if(!$pembayaran)
                                @if($event->harga > 0)
                                    <span class="bg-error-container text-on-error-container px-2.5 py-0.5 rounded-full text-xs font-bold">Belum Bayar</span>
                                    <a href="{{ route('payments.create', $pendaftaran) }}" class="bg-primary text-on-primary px-3 py-1 rounded text-xs font-bold hover:opacity-90 transition-opacity">
                                        Upload Pembayaran
                                    </a>
                                @else
                                    <span class="bg-info-container text-on-info-container px-2.5 py-0.5 rounded-full text-xs font-bold">Gratis</span>
                                    <!-- Automatically valid since free -->
                                    <span class="text-xs text-secondary">Tidak perlu pembayaran</span>
                                @endif
                            @else
                                @if($pembayaran->status === 'pending')
                                    <span class="bg-warning/15 text-warning-container font-bold text-xs px-2.5 py-1 rounded-full border border-warning/20 bg-amber-50 text-amber-700">
                                        Menunggu Validasi
                                    </span>
                                @elseif($pembayaran->status === 'valid')
                                    <span class="bg-emerald-100 text-emerald-800 font-bold text-xs px-2.5 py-1 rounded-full border border-emerald-200">
                                        Dikonfirmasi
                                    </span>
                                    @if($pembayaran->tiket)
                                        <a href="{{ route('tickets.show', $pembayaran->tiket) }}" class="bg-emerald-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
                                            Ambil Tiket
                                        </a>
                                    @endif
                                @elseif($pembayaran->status === 'ditolak')
                                    <span class="bg-red-100 text-red-800 font-bold text-xs px-2.5 py-1 rounded-full border border-red-200">
                                        Ditolak
                                    </span>
                                    <a href="{{ route('payments.create', $pendaftaran) }}" class="bg-primary text-on-primary px-3 py-1 rounded text-xs font-bold hover:opacity-90 transition-opacity">
                                        Upload Ulang
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 px-6 text-center bg-surface-container-lowest border border-outline-variant border-dashed rounded-xl">
                    <span class="material-symbols-outlined text-4xl text-secondary mb-2">event_note</span>
                    <p class="text-sm text-secondary font-medium">Anda belum terdaftar di event apa pun.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Browse Events Grid Section -->
    <section class="mb-12">
        <h2 class="font-bold text-2xl text-on-surface mb-6">Event Mendatang</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($upcomingEvents as $event)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden group hover:border-primary hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <!-- Image Banner -->
                    <div class="h-48 relative overflow-hidden bg-surface-container-low">
                        @if($event->foto_banner_event)
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 src="{{ asset('storage/' . $event->foto_banner_event) }}" 
                                 alt="{{ $event->judul }}"/>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-secondary">
                                <span class="material-symbols-outlined text-4xl mb-1">Foto</span>
                                <span class="text-xs">Banner tidak tersedia</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                            {{ $event->kategori->nama }}
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex flex-col mb-4">
                            <span class="text-primary font-bold text-xs uppercase tracking-wider">
                                {{ $event->tanggal_pelaksanaan->format('M d, Y') }}
                            </span>
                            <h3 class="font-bold text-xl text-on-surface mt-1 group-hover:text-primary transition-colors line-clamp-2">
                                {{ $event->judul }}
                            </h3>
                        </div>

                        <div class="space-y-3 mb-6 flex-grow">
                            <div class="flex items-center gap-2.5 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary">location_on</span>
                                <span class="truncate">{{ $event->lokasi }}</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary">payments</span>
                                <span class="font-semibold text-emerald-600">
                                    {{ $event->harga > 0 ? 'Rp ' . number_format($event->harga, 0, ',', '.') : 'Gratis' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2.5 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-[20px] text-secondary">group</span>
                                @php
                                    $registered = \App\Models\Pendaftaran::where('event_id', $event->id)
                                        ->whereDoesntHave('pembayaran', function ($query) {
                                            $query->where('status', 'ditolak');
                                        })
                                        ->count();
                                    $available = $event->kapasitas - $registered;
                                    $percent = $event->kapasitas > 0 ? round(($registered / $event->kapasitas) * 100) : 0;
                                @endphp
                                <span>{{ $registered }}/{{ $event->kapasitas }} Registered</span>
                                <div class="w-24 h-1.5 bg-surface-container rounded-full overflow-hidden ml-2">
                                    <div class="bg-primary h-full transition-all duration-300" style="width: {{ $percent }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        @php
                            $now = now();
                            $status = 'akan_datang';
                            if ($now >= $event->tanggal_pelaksanaan && $now <= $event->tanggal_selesai) {
                                $status = 'berjalan';
                            } elseif ($now > $event->tanggal_selesai) {
                                $status = 'selesai';
                            }
                        @endphp
                        <div class="mt-auto pt-4 border-t border-outline-variant/30">
                            @if($status === 'selesai')
                                <a href="{{ route('events.show', $event) }}" class="block w-full py-3 text-center bg-surface-container-high text-on-surface-variant font-bold rounded-lg transition-all duration-200">
                                    Event Selesai
                                </a>
                            @elseif($status === 'berjalan')
                                <a href="{{ route('events.show', $event) }}" class="block w-full py-3 text-center bg-surface-container-low text-primary font-bold rounded-lg border border-outline-variant hover:bg-primary hover:text-on-primary transition-all duration-200">
                                    Detail (Sedang Berjalan)
                                </a>
                            @else
                                <a href="{{ route('events.show', $event) }}" 
                                   class="block w-full py-3 text-center bg-primary text-on-primary font-bold rounded-lg hover:opacity-90 active:scale-95 transition-all duration-200">
                                    Daftar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-surface-container-lowest border border-outline-variant rounded-xl">
                    <span class="material-symbols-outlined text-5xl text-secondary mb-3">calendar_today</span>
                    <h3 class="text-xl font-bold text-on-surface mb-1">No Upcoming Events</h3>
                    <p class="text-secondary text-sm">You've registered for all active events!</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
