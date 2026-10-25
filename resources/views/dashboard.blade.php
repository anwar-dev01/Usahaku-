<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(10px, -12px) scale(1.05); }
        }
        .fade-up {
            opacity: 0;
            animation: fadeSlideUp 0.55s ease-out forwards;
        }
        .stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px) rotate(-0.3deg);
        }
        .blob {
            animation: floatBlob 7s ease-in-out infinite;
        }
        .timeline-line::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 2rem;
            bottom: -0.5rem;
            width: 2px;
            background: linear-gradient(to bottom, rgba(99,102,241,0.25), transparent);
        }
        .timeline-item:last-child .timeline-line::before {
            display: none;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header greeting dengan elemen dekoratif --}}
            <div class="relative overflow-hidden bg-linear-to-br from-purple-600 via-violet-700 to-indigo-900 rounded-3xl shadow-lg shadow-purple-200 p-7 text-white fade-up">
                <div class="blob absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="blob absolute -bottom-14 right-24 w-28 h-28 bg-indigo-300/20 rounded-full blur-2xl" style="animation-delay: -3s;"></div>
                <div class="relative">
                    <p class="text-blue-200 text-xs font-medium tracking-wide uppercase mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <h3 class="text-2xl font-bold">Halo, {{ Auth::user()->name }} 👋</h3>
                    <p class="text-blue-100 text-sm mt-1.5">
                        Login sebagai
                        <span class="inline-block bg-white/15 px-2 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide ml-1">{{ Auth::user()->role }}</span>
                    </p>
                </div>
            </div>

            {{-- Stat cards: ukuran & irama tidak seragam --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4">

                <div class="stat-card fade-up lg:col-span-4 bg-linear-to-br from-emerald-50 to-white rounded-2xl shadow-md shadow-emerald-100 p-5 border border-emerald-100" style="animation-delay: 0.05s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Kas Masuk (Bulan Ini)</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1 tabular-nums" data-counter data-value="{{ $kasMasuk }}">Rp 0</p>
                        </div>
                        <div class="bg-linear-to-br from-emerald-400 to-green-600 p-3 rounded-2xl shadow-lg shadow-emerald-200 rotate-3">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m0-16l6 6m-6-6l-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card fade-up lg:col-span-4 bg-linear-to-br from-rose-50 to-white rounded-2xl shadow-md shadow-rose-100 p-5 border border-rose-100" style="animation-delay: 0.12s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Kas Keluar (Bulan Ini)</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1 tabular-nums" data-counter data-value="{{ $kasKeluar }}">Rp 0</p>
                        </div>
                        <div class="bg-linear-to-br from-rose-400 to-red-600 p-3 rounded-2xl shadow-lg shadow-rose-200 -rotate-3">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20V4m0 16l-6-6m6 6l6-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card fade-up lg:col-span-4 bg-linear-to-br from-amber-50 to-white rounded-2xl shadow-md shadow-amber-100 p-5 border border-amber-100" style="animation-delay: 0.19s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1 tabular-nums">{{ $hadirHariIni }} <span class="text-gray-400 text-lg font-medium">/ {{ $totalKaryawan }}</span></p>
                        </div>
                        <div class="bg-linear-to-br from-amber-400 to-yellow-500 p-3 rounded-2xl shadow-lg shadow-amber-200 rotate-3">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card fade-up lg:col-span-12 sm:col-span-2 bg-linear-to-r from-blue-50 via-white to-white rounded-2xl shadow-md shadow-blue-100 p-5 border border-blue-100 flex items-center justify-between" style="animation-delay: 0.26s;">
                    <div class="flex items-center gap-4">
                        <div class="bg-linear-to-br from-blue-400 to-indigo-600 p-3 rounded-2xl shadow-lg shadow-blue-200 -rotate-3">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-3.999-4A4 4 0 0015 11z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Karyawan</p>
                            <p class="text-2xl font-bold text-gray-800 tabular-nums" data-counter data-value="{{ $totalKaryawan }}" data-plain="true">0</p>
                        </div>
                    </div>
                    <p class="hidden sm:block text-xs text-gray-400 max-w-[10rem] text-right">Total karyawan aktif yang terdaftar di sistem</p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="fade-up lg:col-span-2 bg-white rounded-3xl shadow-md p-6 border border-gray-100" style="animation-delay: 0.32s;">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-1.5 h-5 bg-linear-to-b from-blue-500 to-indigo-600 rounded-full"></span>
                        <h3 class="font-semibold text-gray-800">Grafik Kas Masuk vs Keluar</h3>
                    </div>
                    <div class="h-64">
                        <canvas id="chartKeuangan"></canvas>
                    </div>
                </div>
                <div class="fade-up bg-white rounded-3xl shadow-md p-6 border border-gray-100" style="animation-delay: 0.38s;">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-1.5 h-5 bg-linear-to-b from-purple-500 to-pink-500 rounded-full"></span>
                        <h3 class="font-semibold text-gray-800">Pengeluaran per Kategori</h3>
                    </div>
                    @if($breakdownData->count() > 0)
                        <div class="h-64">
                            <canvas id="chartBreakdown"></canvas>
                        </div>
                    @else
                        <div class="h-64 flex flex-col items-center justify-center text-gray-400 text-sm gap-2">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                            <p class="text-center">Belum ada pengeluaran bulan ini</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Activity feed sebagai timeline --}}
            <div class="fade-up bg-white rounded-3xl shadow-md p-6 border border-gray-100" style="animation-delay: 0.44s;">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-1.5 h-5 bg-linear-to-b from-emerald-500 to-teal-500 rounded-full"></span>
                    <h3 class="font-semibold text-gray-800">Aktivitas Terbaru</h3>
                </div>
                <div class="space-y-1">
                    @forelse($aktivitasTerbaru as $item)
                        <div class="timeline-item timeline-line relative flex items-center gap-4 pb-5 pl-1 last:pb-0">
                            <div class="relative z-10 shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                {{ $item->tipe === 'masuk' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                @if($item->tipe === 'masuk')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m0-16l6 6m-6-6l-6 6" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20V4m0 16l-6-6m6 6l6-6" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 flex justify-between items-center rounded-xl px-3 py-2 -ml-1 hover:bg-gray-50 transition-colors">
                                <div>
                                    <p class="font-medium text-gray-700 text-sm">{{ $item->kategori->nama ?? '-' }}</p>
                                    <p class="text-gray-400 text-xs">{{ $item->tanggal->format('d M Y') }}</p>
                                </div>
                                <p class="{{ $item->tipe === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }} font-semibold text-sm tabular-nums">
                                    {{ $item->tipe === 'masuk' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="h-32 flex flex-col items-center justify-center text-gray-400 text-sm gap-2">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <p>Belum ada aktivitas transaksi</p>
                            <a href="{{ route('transaksi.create') }}" class="text-blue-600 hover:underline text-xs font-medium">+ Catat transaksi pertama</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartKeuangan');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Kas Masuk',
                            data: @json($chartMasuk),
                            backgroundColor: 'rgba(16, 185, 129, 0.75)',
                            borderRadius: 8,
                        },
                        {
                            label: 'Kas Keluar',
                            data: @json($chartKeluar),
                            backgroundColor: 'rgba(244, 63, 94, 0.75)',
                            borderRadius: 8,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            @if($breakdownData->count() > 0)
            const ctxBreakdown = document.getElementById('chartBreakdown');
            new Chart(ctxBreakdown, {
                type: 'doughnut',
                data: {
                    labels: @json($breakdownLabels),
                    datasets: [{
                        data: @json($breakdownData),
                        backgroundColor: ['#6366F1', '#0891B2', '#F59E0B', '#F43F5E', '#8B5CF6', '#10B981', '#EC4899'],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                    }
                }
            });
            @endif

            document.querySelectorAll('[data-counter]').forEach(function (el) {
                const target = parseFloat(el.dataset.value);
                const isPlain = el.dataset.plain === 'true';
                const duration = 900;
                const start = performance.now();

                function tick(now) {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(eased * target);
                    el.textContent = isPlain ? current : 'Rp ' + current.toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            });
        });
    </script>
    @endpush
</x-app-layout>