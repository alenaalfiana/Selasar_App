@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 max-w-container-max mx-auto w-full flex-grow">
    <!-- Hero Section -->
    <section class="text-center mb-16">
        <h1 class="font-bold text-5xl md:text-6xl text-primary tracking-tight mb-4">Yuk Temukan Event Menarik di Kampus!</h1>
        <p class="text-lg md:text-xl text-secondary max-w-2xl mx-auto">Daftar seminar, workshop, lomba, dan berbagai kegiatan kampus lainnya secara cepat dan praktis melalui <b>Selasar</b>!</p>
    </section>

<!-- Filter Jenis -->
<section class="flex flex-wrap justify-center gap-3 mb-6">
    <a href="{{ route('home') }}"
       class="px-6 py-2 rounded-full font-semibold text-sm transition-colors
       {{ !request('jenis') && !request('kategori')
            ? 'bg-primary text-on-primary'
            : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:bg-surface-container-high'
       }}">
        Semua Event
    </a>

    @foreach($jenises as $jenis)
        <a href="{{ route('home', [
            'jenis' => $jenis->id,
            'kategori' => request('kategori')
        ]) }}"
           class="px-6 py-2 rounded-full font-semibold text-sm transition-colors
           {{ request('jenis') == $jenis->id
                ? 'bg-primary text-on-primary'
                : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:bg-surface-container-high'
           }}">
            {{ $jenis->nama }}
        </a>
    @endforeach
</section>

<!-- Filter Kategori -->
<section class="flex flex-wrap justify-center gap-3 mb-8">
    @foreach($kategoris as $kategori)
        <a href="{{ route('home', [
            'kategori' => $kategori->id,
            'jenis' => request('jenis')
        ]) }}"
           class="px-6 py-2 rounded-full font-semibold text-sm transition-colors
           {{ request('kategori') == $kategori->id
                ? 'bg-primary text-on-primary'
                : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:bg-surface-container-high'
           }}">
            {{ $kategori->nama }}
        </a>
    @endforeach
</section>

@if(request('jenis') || request('kategori'))
<section class="text-center mb-12">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
        Reset Filter
    </a>
</section>
@endif

    <!-- Grid Layout for Events -->
    <section class="mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden group hover:border-primary hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <!-- Image Banner -->
                    <div class="h-48 relative overflow-hidden bg-surface-container-low">
                        @if($event->foto_banner_event)
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 src="{{ asset('storage/' . $event->foto_banner_event) }}" 
                                 alt="{{ $event->judul }}"/>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-secondary">
                                <span class="material-symbols-outlined text-4xl mb-1">image</span>
                                <span class="text-xs">No banner available</span>
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
                                <a href="{{ route('events.show', $event) }}" class="block w-full py-3 text-center bg-surface-container-high text-on-surface-variant font-bold rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-all duration-200">
                                    Event Selesai
                                </a>
                            @elseif($status === 'berjalan')
                                <a href="{{ route('events.show', $event) }}" class="block w-full py-3 text-center bg-surface-container-low text-primary font-bold rounded-lg border border-outline-variant hover:bg-primary hover:text-on-primary transition-all duration-200">
                                    Detail (Sedang Berjalan)
                                </a>
                            @else
                                <a href="{{ route('events.show', $event) }}" 
                                   class="block w-full py-3 text-center bg-surface-container-low text-primary font-bold rounded-lg border border-outline-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-200">
                                    Detail Event
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-surface-container-lowest border border-outline-variant rounded-xl">
                    <span class="material-symbols-outlined text-5xl text-secondary mb-3">calendar_today</span>
                    <h3 class="text-xl font-bold text-on-surface mb-1">No Events Found</h3>
                    <p class="text-secondary text-sm">Check back later for exciting activities!</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
