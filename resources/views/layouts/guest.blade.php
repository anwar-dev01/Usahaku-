<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Usahaku') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:600,700,800|inter:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] text-slate-800 bg-white antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-10 px-4 bg-slate-50">

            <a href="/" class="mb-8 text-center">
                <span class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl text-blue-800">Usahaku</span>
                <p class="text-slate-500 text-sm mt-1">Kas, absensi, dan gaji dalam satu aplikasi</p>
            </a>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} Usahaku. Dibuat untuk usaha kecil yang ingin tumbuh rapi.
            </p>
        </div>
    </body>
</html>