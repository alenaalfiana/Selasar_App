@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 max-w-4xl mx-auto w-full flex-grow">
    <!-- Breadcrumb or back button -->
    <div class="mb-6">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-secondary hover:text-primary transition-colors text-sm font-semibold">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to Browse
        </a>
    </div>

    <!-- Main Card container -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Banner Image -->
        <div class="w-full relative bg-surface-container-low flex justify-center">
            @if($event->foto_banner_event)
                <img src="{{ asset('storage/' . $event->foto_banner_event) }}" class="w-full h-auto object-contain" alt="{{ $event->judul }}">
            @else
                <div class="w-full py-32 flex flex-col items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-6xl mb-2">Foto</span>
                    <p class="text-sm font-medium">Banner tidak tersedia</p>
                </div>
            @endif
            <div class="absolute bottom-6 left-6 flex gap-2">
                <span class="bg-primary text-on-primary px-4 py-1.5 rounded-full text-xs font-bold shadow-md">
                    {{ $event->kategori->nama }}
                </span>
                <span class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full text-xs font-bold shadow-md">
                    {{ $event->jenis->nama }}
                </span>
            </div>
        </div>

        <!-- Details Area -->
        <div class="p-6 md:p-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-on-surface mb-6 leading-tight">{{ $event->judul }}</h1>

            <!-- Quick Specs Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 p-6 bg-surface-container rounded-xl border border-outline-variant/55">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[28px] mt-0.5">calendar_month</span>
                    <div>
                        <span class="block text-xs text-secondary font-medium uppercase tracking-wider">Tanggal & Waktu</span>
                        <span class="text-on-surface font-bold text-base">{{ $event->tanggal_pelaksanaan->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[28px] mt-0.5">location_on</span>
                    <div>
                        <span class="block text-xs text-secondary font-medium uppercase tracking-wider">Lokasi</span>
                        <span class="text-on-surface font-bold text-base">{{ $event->lokasi }}</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[28px] mt-0.5">payments</span>
                    <div>
                        <span class="block text-xs text-secondary font-medium uppercase tracking-wider">Harga Tiket</span>
                        <span class="font-extrabold text-emerald-600 text-lg">
                            {{ $event->harga > 0 ? 'Rp ' . number_format($event->harga, 0, ',', '.') : 'Gratis' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[28px] mt-0.5">group</span>
                    <div>
                        <span class="block text-xs text-secondary font-medium uppercase tracking-wider">Kursi Tersedia</span>
                        @php
                            $registered = \App\Models\Pendaftaran::where('event_id', $event->id)
                                ->whereDoesntHave('pembayaran', function ($query) {
                                    $query->where('status', 'ditolak');
                                })
                                ->count();
                            $available = $event->kapasitas - $registered;
                        @endphp
                        <span class="font-bold text-base {{ $available > 0 ? 'text-primary' : 'text-error' }}">
                            {{ $available > 0 ? $available . ' kursi' : 'Penuh / Full' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="prose max-w-none mb-8">
                <h3 class="text-xl font-bold text-on-surface border-b border-outline-variant/30 pb-2 mb-4">Deskripsi</h3>
                <p class="text-on-surface-variant text-base leading-relaxed whitespace-pre-line">{{ $event->deskripsi }}</p>
            </div>

            <!-- Payment instructions if paid -->
            @if($event->nama_rekening && $event->no_rekening_pembayaran)
                <div class="mb-8 p-5 bg-tertiary-container text-on-tertiary-container rounded-xl border border-outline-variant/20">
                    <h4 class="flex items-center gap-2 font-bold text-lg mb-2">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Rekening Pembayaran
                    </h4>
                    <p class="text-sm">Untuk pendaftaran berbayar, Anda akan diminta mengunggah bukti transfer setelah mendaftar.</p>
                    <div class="mt-3 bg-surface-container-lowest p-3 rounded-lg border border-outline-variant/40 flex flex-wrap gap-6 items-center">
                        <div>
                            <span class="block text-xs text-secondary">Bank / Rekening</span>
                            <span class="font-bold text-on-surface">{{ $event->no_rekening_pembayaran }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-secondary">Atas Nama</span>
                            <span class="font-bold text-on-surface">{{ $event->nama_rekening }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Area -->
            <div class="border-t border-outline-variant/30 pt-8 flex justify-center">
                @php
                    $now = now();
                    $status = 'akan_datang';
                    if ($now >= $event->tanggal_pelaksanaan && $now <= $event->tanggal_selesai) {
                        $status = 'berjalan';
                    } elseif ($now > $event->tanggal_selesai) {
                        $status = 'selesai';
                    }

                    $isRegistered = false;
                    if (auth()->check()) {
                        $isRegistered = \App\Models\Pendaftaran::where('user_id', auth()->id())
                            ->where('event_id', $event->id)->exists();
                    }
                @endphp

                @if($status === 'selesai')
                    <div class="w-full sm:w-80 py-4 bg-surface-container-high text-on-surface-variant font-bold text-center text-lg rounded-xl border border-outline-variant/50">
                        Event Telah Selesai
                    </div>
                @elseif($isRegistered)
                    <div class="w-full sm:w-80 py-4 bg-emerald-100 text-emerald-800 font-bold text-center text-lg rounded-xl border border-emerald-300">
                        Anda Sudah Terdaftar
                    </div>
                @elseif($status === 'berjalan' || $status === 'akan_datang')
                    @auth
                        @if($available > 0)
                            <form action="{{ route('events.register', $event) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-80 py-4 bg-primary text-on-primary font-bold text-lg rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-md shadow-primary/20">
                                    {{ $status === 'berjalan' ? 'Daftar Event (Sedang Berjalan)' : 'Daftar Event Sekarang' }}
                                </button>
                            </form>
                        @else
                            <button class="w-full sm:w-80 py-4 bg-secondary-container text-on-secondary-container font-bold text-lg rounded-xl cursor-not-allowed" disabled>
                                Kapasitas Penuh
                            </button>
                        @endif
                    @else
                        <div class="w-full bg-error-container text-on-error-container p-4 rounded-xl text-center border border-error/20">
                            <p class="font-medium text-base mb-1">Daftar sekarang untuk memesan kursi Anda.</p>
                            <span class="text-sm">Silakan <a href="{{ route('login') }}" class="underline font-bold text-primary hover:opacity-80">Login</a> atau <a href="{{ route('register') }}" class="underline font-bold text-primary hover:opacity-80">Register</a> terlebih dahulu.</span>
                        </div>
                    @endauth
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
