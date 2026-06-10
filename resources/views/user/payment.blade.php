@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 max-w-xl mx-auto w-full flex-grow flex items-center justify-center">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm w-full">
        <!-- Header -->
        <div class="p-6 border-b border-outline-variant/30">
            <h1 class="text-2xl font-bold text-on-surface">Upload Bukti Pembayaran</h1>
            <p class="text-xs text-secondary mt-1">Lengkapi pembayaran untuk menyelesaikan pendaftaran Anda.</p>
        </div>

        <!-- Body -->
        <div class="p-6">
            <!-- Event & Billing Info -->
            <div class="mb-6 p-5 bg-primary-fixed text-on-primary-fixed rounded-xl border border-primary/10">
                <h4 class="font-bold text-base mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    Rincian Pembayaran
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="opacity-80">Event:</span>
                        <span class="font-bold text-right truncate max-w-[200px]">{{ $pendaftaran->event->judul }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-80">Total Tagihan:</span>
                        <span class="font-black text-emerald-700">Rp {{ number_format($pendaftaran->event->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-primary/20 my-2 pt-2">
                        <span class="block opacity-80 mb-1">Transfer ke:</span>
                        <span class="font-bold block text-on-primary-fixed">{{ $pendaftaran->event->no_rekening_pembayaran }}</span>
                        <span class="text-xs block opacity-85">atas nama <b>{{ $pendaftaran->event->nama_rekening }}</b></span>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('payments.store', $pendaftaran) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($pendaftaran->event->harga > 0)
                <div class="mb-6">
                    <label for="foto_bukti_pembayaran" class="block text-sm font-bold text-on-surface mb-2">
                        Unggah Bukti Transfer (Gambar)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed rounded-xl hover:border-primary transition-colors cursor-pointer relative">
                        <div class="space-y-1 text-center">
                            <span class="material-symbols-outlined text-4xl text-secondary mb-2">cloud_upload</span>
                            <div class="flex text-sm text-on-surface">
                                <span class="font-bold text-primary hover:underline">Choose a file</span>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-secondary">PNG, JPG, JPEG up to 2MB</p>
                        </div>
                        <input type="file" id="foto_bukti_pembayaran" name="foto_bukti_pembayaran" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required 
                               onchange="previewImage(event)">
                    </div>
                    <!-- Display selected file name and preview -->
                    <div id="preview-container" class="mt-4 hidden flex-col items-center">
                        <p id="file-name" class="text-sm font-semibold text-primary mb-2 text-center"></p>
                        <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-outline-variant shadow-sm object-contain" />
                    </div>
                    
                    <script>
                        function previewImage(event) {
                            var input = event.target;
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var container = document.getElementById('preview-container');
                                    container.classList.remove('hidden');
                                    container.classList.add('flex');
                                    document.getElementById('image-preview').src = e.target.result;
                                    document.getElementById('file-name').innerText = input.files[0].name;
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                    @error('foto_bukti_pembayaran')
                        <p class="text-sm text-error mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 bg-primary text-on-primary font-bold rounded-lg hover:opacity-90 active:scale-95 transition-all">
                        Kirim Bukti Pembayaran
                    </button>
                    <a href="{{ route('dashboard') }}" class="w-full py-3 text-center bg-surface-container-low text-secondary font-bold rounded-lg hover:bg-surface-container-high transition-colors">
                        Batal
                    </a>
                </div>
                @else
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600 text-2xl">check_circle</span>
                    <p class="font-medium text-sm">Event ini gratis. Klik tombol di bawah untuk mendapatkan tiket Anda secara langsung.</p>
                </div>
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 active:scale-95 transition-all shadow-md">
                        Dapatkan Tiket Gratis
                    </button>
                    <a href="{{ route('dashboard') }}" class="w-full py-3 text-center bg-surface-container-low text-secondary font-bold rounded-lg hover:bg-surface-container-high transition-colors">
                        Batal
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
