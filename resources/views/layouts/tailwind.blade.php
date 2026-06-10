<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Manajemen Event Kampus - {{ $title ?? 'Selasar' }}</title>
    
    <!-- Tailwind CSS & Google Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Alpine.js for interactive dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#f7f9fb",
                        "on-secondary-fixed": "#0b1c30",
                        "primary": "#00236f",
                        "on-error": "#ffffff",
                        "inverse-surface": "#2d3133",
                        "on-tertiary-fixed": "#131b2e",
                        "secondary": "#505f76",
                        "on-tertiary-fixed-variant": "#3f465c",
                        "on-background": "#191c1e",
                        "surface-container-low": "#f2f4f6",
                        "on-surface": "#191c1e",
                        "tertiary-fixed": "#dae2fd",
                        "on-primary-fixed-variant": "#264191",
                        "secondary-fixed": "#d3e4fe",
                        "on-primary-fixed": "#00164e",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#eceef0",
                        "outline": "#757682",
                        "tertiary-fixed-dim": "#bec6e0",
                        "on-primary": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-surface-variant": "#444651",
                        "surface-dim": "#d8dadc",
                        "outline-variant": "#c5c5d3",
                        "on-secondary-container": "#54647a",
                        "secondary-fixed-dim": "#b7c8e1",
                        "on-secondary": "#ffffff",
                        "on-primary-container": "#90a8ff",
                        "tertiary": "#222a3e",
                        "surface-bright": "#f7f9fb",
                        "on-tertiary-container": "#a4acc5",
                        "error": "#ba1a1a",
                        "on-tertiary": "#ffffff",
                        "surface-tint": "#4059aa",
                        "background": "#f7f9fb",
                        "surface-container-highest": "#e0e3e5",
                        "inverse-on-surface": "#eff1f3",
                        "tertiary-container": "#384055",
                        "primary-fixed-dim": "#b6c4ff",
                        "primary-container": "#1e3a8a",
                        "primary-fixed": "#dce1ff",
                        "surface-variant": "#e0e3e5",
                        "inverse-primary": "#b6c4ff",
                        "surface-container-high": "#e6e8ea",
                        "on-secondary-fixed-variant": "#38485d",
                        "secondary-container": "#d0e1fb",
                        "on-error-container": "#93000a"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "container-max": "1280px",
                        "gutter": "24px",
                        "margin-mobile": "16px",
                        "margin-desktop": "48px",
                        "unit": "4px"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c5c5d3; border-radius: 10px; }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col">

    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-surface-container-lowest border-b border-outline-variant h-16 flex items-center justify-between px-6 md:px-margin-desktop">
        <div class="flex items-center gap-8">
            <a href="{{ url('/') }}" class="text-headline-md font-bold text-primary tracking-tight">Selasar</a>
        </div>
        
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-secondary hover:text-primary font-semibold text-body-sm px-3 py-2 transition-colors">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-primary text-on-primary font-bold text-body-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity">Daftar</a>
                @endif
            @else
                <!-- Navigation links -->
                <nav class="hidden md:flex items-center gap-6 mr-4">
                    <a class="text-secondary font-medium hover:text-primary text-body-sm {{ Route::is('home') ? 'text-primary font-bold' : '' }}" href="{{ url('/') }}">Jelajahi Event</a>
                    <a class="text-secondary font-medium hover:text-primary text-body-sm {{ Route::is('dashboard') ? 'text-primary font-bold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </nav>

                <!-- Notifications Dropdown (Alpine.js) -->
                @php
                    $unreadNotifications = auth()->user()->unreadNotifications;
                @endphp
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="material-symbols-outlined text-secondary hover:bg-surface-container-low p-2 rounded-full transition-colors relative">
                        notifications
                        @if($unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-error rounded-full"></span>
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-surface-container-lowest border border-outline-variant rounded-lg shadow-lg py-2 z-50">
                        <div class="px-4 py-2 border-b border-outline-variant font-bold text-sm text-primary flex justify-between items-center">
                            <span>Notifications</span>
                            @if($unreadNotifications->count() > 0)
                                <a href="{{ route('notifications.markAsRead') }}" class="text-xs text-secondary hover:underline">Tandai semua sudah dibaca</a>
                            @endif
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse($unreadNotifications as $notification)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-surface-container border-b border-outline-variant/30 last:border-b-0 transition-colors">
                                    <p class="text-sm text-on-surface font-medium">{{ $notification->data['title'] ?? $notification->data['message'] ?? 'Notification' }}</p>
                                    <span class="text-xs text-secondary">{{ $notification->created_at->diffForHumans() }}</span>
                                </a>
                            @empty
                                <div class="px-4 py-6 text-center text-secondary text-sm">Tidak ada notifikasi baru</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown (Alpine.js) -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold text-sm">
                            {{ substr(auth()->user()->nama, 0, 1) }}
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-surface-container-lowest border border-outline-variant rounded-lg shadow-lg py-2 z-50">
                        <div class="px-4 py-2 border-b border-outline-variant">
                            <p class="text-sm font-semibold text-on-surface truncate">{{ auth()->user()->nama }}</p>
                            <p class="text-xs text-secondary truncate">{{ auth()->user()->email }}</p>
                        </div>
                        @if(auth()->user()->role_as === 'admin')
                            <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container transition-colors">Panel Admin</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container transition-colors">Dashboard</a>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-sm text-error hover:bg-error-container/20 transition-colors border-t border-outline-variant/30">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </header>

    <!-- Content Canvas -->
    <main class="flex-grow pt-16 flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full py-8 px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-container-highest border-t border-outline-variant">
        <div class="flex items-center gap-2">
            <span class="text-label-md font-bold text-primary">Selasar</span>
            <span class="text-body-sm text-on-surface-variant">© 2026 Manajemen Event Kampus - Selasar. All rights reserved.</span>
        </div>
    </footer>

</body>
</html>
