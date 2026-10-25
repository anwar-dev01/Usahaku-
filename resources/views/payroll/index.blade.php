<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Payroll / Gaji Karyawan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl shadow-xs p-6 text-white flex flex-wrap items-center justify-between gap-4">
                <form method="GET" class="flex flex-wrap items-center gap-3">
                    <label class="font-medium">Periode:</label>
                    <input type="month" name="periode" value="{{ $periode }}" onchange="this.form.submit()" class="rounded-xl text-gray-800 px-3 py-2">
                </form>
                <svg class="w-8 h-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <form action="{{ route('payroll.generate') }}" method="POST">
                @csrf
                <input type="hidden" name="periode" value="{{ $periode }}">
                <button type="submit" class="flex items-center gap-2 bg-violet-500 hover:bg-violet-600 text-white px-5 py-3 rounded-xl font-medium transition-colors shadow-xs" onclick="return confirm('Generate ulang payroll untuk periode ini?')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Generate Payroll Periode Ini
                </button>
            </form>

            <!-- Versi Tabel (Desktop) -->
            <div class="hidden md:block bg-white rounded-2xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Hadir</th>
                            <th class="px-6 py-3">Izin</th>
                            <th class="px-6 py-3">Alpha</th>
                            <th class="px-6 py-3">Potongan</th>
                            <th class="px-6 py-3">Total Gaji</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payrolls as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm shrink-0">
                                            {{ strtoupper(substr($p->karyawan->nama, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $p->karyawan->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $p->jumlah_hadir }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $p->jumlah_izin }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $p->jumlah_alpha }}</td>
                                <td class="px-6 py-4 text-red-500 font-mono">Rp {{ number_format($p->potongan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800 font-mono">Rp {{ number_format($p->total_gaji, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $p->status === 'dibayar' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $p->status === 'dibayar' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->status === 'draft')
                                        <form action="{{ route('payroll.bayar', $p) }}" method="POST" onsubmit="return confirm('Tandai gaji ini sudah dibayar?')">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1.5 text-violet-500 hover:text-violet-600 text-xs font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Tandai Dibayar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">{{ $p->tanggal_dibayar?->format('d M Y') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center text-gray-400 gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm">Belum ada payroll untuk periode ini</p>
                                        <p class="text-xs text-gray-400">Klik "Generate Payroll Periode Ini" di atas</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Versi Card (Mobile) -->
            <div class="md:hidden space-y-3">
                @forelse($payrolls as $p)
                    <div class="bg-white rounded-2xl shadow-xs p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm shrink-0">
                                    {{ strtoupper(substr($p->karyawan->nama, 0, 1)) }}
                                </div>
                                <p class="font-medium text-gray-800">{{ $p->karyawan->nama }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $p->status === 'dibayar' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->status === 'dibayar' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                {{ ucfirst($p->status) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-sm border-t border-gray-100 pt-3 mb-3 text-center">
                            <div>
                                <p class="text-xs text-gray-400">Hadir</p>
                                <p class="text-gray-700 font-medium">{{ $p->jumlah_hadir }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Izin</p>
                                <p class="text-gray-700 font-medium">{{ $p->jumlah_izin }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Alpha</p>
                                <p class="text-gray-700 font-medium">{{ $p->jumlah_alpha }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                            <div>
                                <p class="text-xs text-gray-400">Potongan</p>
                                <p class="text-red-500 font-mono text-sm">Rp {{ number_format($p->potongan, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400">Total Gaji</p>
                                <p class="text-gray-800 font-semibold font-mono">Rp {{ number_format($p->total_gaji, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @if($p->status === 'draft')
                            <form action="{{ route('payroll.bayar', $p) }}" method="POST" onsubmit="return confirm('Tandai gaji ini sudah dibayar?')" class="mt-3 pt-3 border-t border-gray-100">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-violet-50 text-violet-500 py-2 rounded-xl text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Tandai Dibayar
                                </button>
                            </form>
                        @else
                            <p class="text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100 text-center">Dibayar {{ $p->tanggal_dibayar?->format('d M Y') }}</p>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-xs p-8 text-center">
                        <p class="text-sm text-gray-400 mb-2">Belum ada payroll untuk periode ini</p>
                        <p class="text-xs text-gray-400">Klik "Generate Payroll Periode Ini" di atas</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>