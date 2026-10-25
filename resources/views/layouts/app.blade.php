<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="group">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Usahaku') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
        /* CSS Darurat khusus HP: Sembunyikan sidebar secara mutlak kalau sidebarOpen bernilai false */
        @media (max-width: 1023px) {
            #sidebar:not([class*="translate-x-0"]) {
                display: none !important;
            }
        }
        </style>
    </head>
    <body
        class="font-inter antialiased bg-gray-100 text-gray-600"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
    >
        <div class="flex h-[100dvh] overflow-hidden">
            @include('components.app.sidebar')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                <!-- Header -->
                <header class="sticky top-0 bg-gradient-to-r from-purple-700 via-violet-700 to-indigo-800 border-b border-purple-900/30 shadow-lg z-30">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-16">
                            
                            <!-- 1. Tombol Hamburger (Ditambah p-2 dan mr-2 biar ada jarak) -->
                            <button class="relative z-50 p-2 mr-2 text-purple-100 hover:text-white lg:hidden" onclick="toggleSidebar(event)">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <rect x="4" y="5" width="16" height="2" />
                                    <rect x="4" y="11" width="16" height="2" />
                                    <rect x="4" y="17" width="16" height="2" />
                                </svg>
                            </button>

                            <!-- 2. Bagian Judul (Biar ga nabrak, dibungkus div truncate) -->
                            @isset($header)
                                <div class="flex-1 min-w-0 px-2">
                                    <div class="truncate text-white font-semibold">
                                        {{ $header }}
                                    </div>
                                </div>
                            @else
                                <div class="flex-1 min-w-0"></div>
                            @endisset

                            <!-- 3. Bagian Kanan (Nama admin disembunyiin di HP) -->
                            <div class="flex items-center gap-3 ml-2 flex-shrink-0">
                                <!-- hidden sm:inline bikin nama ilang di HP tapi muncul di laptop -->
                                <span class="hidden sm:inline text-sm text-purple-100">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-rose-200 hover:text-white">Logout</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </header>

                <main class="grow">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
<script>
    function toggleSidebar(event) {
        event.stopPropagation();
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            // Pakai class toggle biar buka-tutupnya mulus dan nggak bentrok
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
        }
    }

    // Tutup sidebar otomatis kalau layar diklik di luar area
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const headerButton = document.querySelector('header button.lg\\:hidden');
        
        // Kalau layar HP, dan yang diklik bukan sidebar & bukan tombol burger -> Tutup!
        if (window.innerWidth < 1024 && sidebar && !sidebar.contains(event.target) && headerButton && !headerButton.contains(event.target)) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
        }
    });
</script>