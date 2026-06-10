@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 flex-grow flex items-center justify-center min-h-[calc(100vh-80px)]">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-lg w-full max-w-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-primary mb-2">Create an Account</h1>
            <p class="text-secondary text-sm">Bergabunglah dengan Selasar untuk mengikuti berbagai event.</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="nama" class="block text-sm font-bold text-on-surface mb-1">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus class="w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('nama') border-error @enderror">
                @error('nama')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="no_hp" class="block text-sm font-bold text-on-surface mb-1">No HP</label>
                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" class="w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('no_hp') border-error @enderror">
                @error('no_hp')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-on-surface mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('email') border-error @enderror">
                @error('email')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-on-surface mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('password') border-error @enderror">
                @error('password')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password-confirm" class="block text-sm font-bold text-on-surface mb-1">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-2 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface">
            </div>

            <button type="submit" class="w-full py-3 bg-primary text-on-primary font-bold text-lg rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-md mt-4">
                Register
            </button>
            
            <p class="text-center text-sm text-secondary mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Login di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
