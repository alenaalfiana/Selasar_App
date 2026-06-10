@extends('layouts.tailwind')

@section('content')
<div class="px-6 md:px-margin-desktop py-12 flex-grow flex items-center justify-center min-h-[calc(100vh-80px)]">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-lg w-full max-w-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-primary mb-2">Welcome Back!</h1>
            <p class="text-secondary text-sm">Masuk untuk melanjutkan pendaftaran event.</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-bold text-on-surface mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('email') border-error @enderror">
                @error('email')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-on-surface mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface @error('password') border-error @enderror">
                @error('password')
                    <p class="text-error text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" class="rounded text-primary focus:ring-primary bg-surface-container-low border-outline-variant" {{ old('remember') ? 'checked' : '' }}>
                    <span class="text-sm text-secondary font-medium">Remember Me</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-primary hover:text-primary-600 transition-colors">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full py-3 bg-primary text-on-primary font-bold text-lg rounded-xl hover:opacity-90 active:scale-95 transition-all shadow-md mt-2">
                Login
            </button>
            
            <p class="text-center text-sm text-secondary mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-primary hover:underline">Register di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
