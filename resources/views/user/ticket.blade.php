@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 max-w-md mx-auto w-full flex-grow flex items-center justify-center">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-lg w-full flex flex-col">
        <!-- Ticket Header (Primary colors) -->
        <div class="bg-primary text-on-primary p-6 text-center">
            <span class="text-[10px] font-black uppercase tracking-widest opacity-75">CAMPUS EVENTS</span>
            <h1 class="text-2xl font-black mt-1">E-TICKET</h1>
        </div>

        <!-- Ticket Body -->
        <div class="p-6 flex flex-col items-center text-center relative">
            <h2 class="font-extrabold text-xl text-on-surface mb-2 leading-tight">
                {{ $tiket->pembayaran->pendaftaran->event->judul }}
            </h2>
            <p class="text-xs text-secondary font-medium mb-6">
                {{ $tiket->pembayaran->pendaftaran->event->tanggal_pelaksanaan->format('d M Y, H:i') }} WIB<br>
                {{ $tiket->pembayaran->pendaftaran->event->lokasi }}
            </p>

            <!-- QR Code Box -->
            <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/50 shadow-inner mb-6 inline-block">
                <canvas id="qrcode" class="mx-auto"></canvas>
            </div>

            <!-- Code display -->
            <div class="mb-6">
                <span class="block text-[10px] font-bold text-secondary uppercase tracking-wider mb-1">Ticket Code</span>
                <span class="font-black text-2xl tracking-widest text-primary font-mono bg-primary-fixed/30 px-4 py-1 rounded-lg">
                    {{ $tiket->kode_tiket }}
                </span>
            </div>

            <!-- Dashed separator line -->
            <div class="w-full flex items-center gap-1.5 my-4">
                <div class="w-3 h-6 bg-surface border-r border-outline-variant rounded-r-full -ml-6"></div>
                <div class="flex-grow border-t-2 border-dashed border-outline-variant"></div>
                <div class="w-3 h-6 bg-surface border-l border-outline-variant rounded-l-full -mr-6"></div>
            </div>

            <!-- Attendee Details -->
            <div class="w-full space-y-3 pt-2 text-sm text-left">
                <div class="flex justify-between items-center">
                    <span class="text-secondary font-medium">Nama Peserta:</span>
                    <span class="font-bold text-on-surface">{{ $tiket->pembayaran->pendaftaran->user->nama }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-secondary font-medium">Status Presensi:</span>
                    @if($tiket->presensi && $tiket->presensi->status === 'hadir')
                        <span class="bg-emerald-100 text-emerald-800 font-bold text-xs px-2.5 py-0.5 rounded-full border border-emerald-200">
                            Sudah Hadir
                        </span>
                    @else
                        <span class="bg-surface-container-high text-secondary font-bold text-xs px-2.5 py-0.5 rounded-full border border-outline-variant">
                            Belum Hadir
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer link back -->
        <div class="p-6 bg-surface-container-low border-t border-outline-variant/30 flex justify-center">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-surface-container-lowest text-primary font-bold text-sm border border-outline-variant rounded-lg hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-200">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- QR code generation script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new QRious({
            element: document.getElementById('qrcode'),
            value: '{{ $tiket->kode_tiket }}',
            size: 180,
            level: 'H'
        });
    });
</script>
@endsection
