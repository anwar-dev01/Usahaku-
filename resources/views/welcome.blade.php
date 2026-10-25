<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usahaku — Kas, Absensi, dan Gaji dalam Satu Aplikasi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:500,600,700,800|inter:400,500,600|jetbrains-mono:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .float-card { animation: float 5s ease-in-out infinite; }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease-out, transform 0.7s ease-out;
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-stagger > * {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal-stagger.is-visible > *:nth-child(1) { transition-delay: 0ms; }
        .reveal-stagger.is-visible > *:nth-child(2) { transition-delay: 90ms; }
        .reveal-stagger.is-visible > *:nth-child(3) { transition-delay: 180ms; }
        .reveal-stagger.is-visible > *:nth-child(4) { transition-delay: 270ms; }
        .reveal-stagger.is-visible > * {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="font-['Inter'] text-slate-800 bg-white antialiased">

    <!-- Nav -->
    <nav class="max-w-6xl mx-auto flex items-center justify-between px-6 py-6">
        <span class="font-['Plus_Jakarta_Sans'] font-extrabold text-xl text-blue-800">Usahaku</span>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all hover:scale-105">Daftar Gratis</a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-6 pt-10 pb-20 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <span class="inline-block text-xs font-semibold uppercase tracking-wider text-blue-700 bg-blue-50 px-3 py-1 rounded-full mb-5">
                Untuk pemilik usaha kecil
            </span>
            <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl sm:text-5xl leading-tight text-slate-900">
                Kas, absensi, dan gaji — beres di satu tempat.
            </h1>
            <p class="mt-5 text-lg text-slate-500 leading-relaxed">
                Usahaku mencatat setiap transaksi kas, memantau kehadiran karyawan, lalu menghitung gaji secara otomatis. Nggak perlu lagi pindah-pindah catatan kertas dan spreadsheet terpisah.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('register') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3.5 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-blue-700/25">
                    Mulai Gratis
                </a>
                <a href="#fitur" class="text-slate-700 font-semibold px-6 py-3.5 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                    Lihat Cara Kerja
                </a>
            </div>
            <div class="mt-10 flex flex-wrap gap-x-8 gap-y-2 text-sm text-slate-500">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    5 modul terhubung
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Gaji dihitung otomatis
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Laporan Excel &amp; PDF
                </span>
            </div>
        </div>

        <!-- Signature: kartu struk kas -->
        <div class="relative mx-auto max-w-sm w-full reveal">
            <div class="absolute -top-3 left-0 right-0 flex justify-between px-2">
                @for ($i = 0; $i < 12; $i++)
                    <span class="w-3 h-3 rounded-full bg-white border border-slate-100"></span>
                @endfor
            </div>
            <div class="float-card bg-white rounded-2xl shadow-xl shadow-blue-900/10 border border-slate-100 p-7 pt-9">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800 text-sm">USAHAKU</p>
                        <p class="text-xs text-slate-400">Laporan Kas Harian</p>
                    </div>
                    <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live
                    </span>
                </div>

                <div class="space-y-3 font-['JetBrains_Mono'] text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kas Masuk</span>
                        <span class="text-emerald-600 font-medium">+ Rp2.000.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kas Keluar</span>
                        <span class="text-red-500 font-medium">− Rp0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Karyawan Hadir</span>
                        <span class="text-slate-700 font-medium">1 / 1</span>
                    </div>
                    <div class="border-t border-dashed border-slate-200 my-3"></div>
                    <div class="flex justify-between text-base">
                        <span class="text-slate-700 font-semibold">Saldo</span>
                        <span class="text-blue-700 font-bold">Rp2.000.000</span>
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-6 text-center">Diperbarui otomatis setiap transaksi dicatat</p>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="bg-slate-50 py-20">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl text-slate-900 text-center reveal">
                Semua yang dibutuhkan usaha kecil
            </h2>
            <p class="text-slate-500 text-center mt-3 max-w-xl mx-auto reveal">
                Empat modul yang saling terhubung, jadi data yang kamu catat sekali langsung terpakai di seluruh laporan.
            </p>

            <div class="reveal-stagger grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-12">
                <div class="bg-white rounded-xl p-6 border border-slate-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-blue-100">
                    <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Kas &amp; Transaksi</h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">Catat kas masuk dan keluar per kategori, kelihatan langsung ke mana uang usaha bergerak.</p>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-blue-100">
                    <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Absensi Karyawan</h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">Tandai hadir, izin, sakit, atau alpha tiap hari. Rekapnya otomatis kepakai buat hitung gaji.</p>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-blue-100">
                    <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2m-2 0h12a2 2 0 012 2v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7a2 2 0 012-2z" /></svg>
                    </div>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Payroll Otomatis</h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">Gaji dihitung sendiri dari data absensi. Tinggal cek dan tandai sudah dibayar.</p>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-blue-100">
                    <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Dashboard &amp; Laporan</h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">Grafik kas masuk-keluar tiap bulan, siap diunduh jadi Excel atau PDF kapan aja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara kerja -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl text-slate-900 text-center reveal">
                Mulai dalam tiga langkah
            </h2>

            <div class="mt-14 space-y-10 reveal-stagger">
                <div class="flex gap-5">
                    <span class="font-['JetBrains_Mono'] text-blue-700 font-semibold text-lg shrink-0">01</span>
                    <div>
                        <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Tambahkan karyawan dan kategori transaksi</h3>
                        <p class="text-sm text-slate-500 mt-1">Masukkan data karyawan sekali, lalu atur kategori kas masuk dan keluar sesuai jenis usahamu.</p>
                    </div>
                </div>
                <div class="flex gap-5">
                    <span class="font-['JetBrains_Mono'] text-blue-700 font-semibold text-lg shrink-0">02</span>
                    <div>
                        <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Catat kas dan absensi setiap hari</h3>
                        <p class="text-sm text-slate-500 mt-1">Setiap transaksi dan kehadiran yang dicatat langsung masuk ke dashboard secara real-time.</p>
                    </div>
                </div>
                <div class="flex gap-5">
                    <span class="font-['JetBrains_Mono'] text-blue-700 font-semibold text-lg shrink-0">03</span>
                    <div>
                        <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-slate-800">Generate payroll dan unduh laporan</h3>
                        <p class="text-sm text-slate-500 mt-1">Gaji terhitung otomatis dari absensi bulan berjalan, laporan siap diunduh kapan pun dibutuhkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-gradient-to-r from-blue-800 to-cyan-700 py-16">
        <div class="max-w-2xl mx-auto px-6 text-center reveal">
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl text-white">
                Siap merapikan pembukuan usahamu?
            </h2>
            <p class="text-blue-100 mt-3">Gratis untuk dicoba, tanpa perlu kartu kredit.</p>
            <a href="{{ route('register') }}" class="inline-block mt-7 bg-white text-blue-800 font-semibold px-7 py-3.5 rounded-lg hover:bg-blue-50 transition-all hover:scale-105 hover:shadow-lg">
                Buat Akun Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 text-center text-sm text-slate-400">
        © {{ date('Y') }} Usahaku. Dibuat untuk usaha kecil yang ingin tumbuh rapi.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            document.querySelectorAll('.reveal, .reveal-stagger').forEach((el) => observer.observe(el));
        });
    </script>

</body>
</html>