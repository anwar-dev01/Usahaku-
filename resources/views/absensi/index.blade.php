<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Absensi Karyawan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl shadow-xs p-6 text-white flex items-center justify-between">
                <form method="GET" class="flex items-center gap-3">
                    <label class="font-medium">Pilih Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()" class="rounded-xl text-gray-800 px-3 py-2">
                </form>
                <svg class="w-8 h-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>

            <!-- Versi Tabel (Desktop) -->
            <div class="hidden md:block bg-white rounded-2xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Jabatan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Jam Masuk</th>
                            <th class="px-6 py-3">Jam Keluar</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($karyawans as $karyawan)
                            @php
                                $absen = $absensis->firstWhere('karyawan_id', $karyawan->id);
                                $statusColor = match($absen->status ?? 'hadir') {
                                    'hadir' => 'bg-green-500',
                                    'izin' => 'bg-blue-400',
                                    'sakit' => 'bg-yellow-500',
                                    'alpha' => 'bg-red-500',
                                    default => 'bg-gray-400',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm shrink-0">
                                            {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $karyawan->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $karyawan->jabatan }}</td>
                                <form action="{{ route('absensi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $statusColor }} shrink-0"></span>
                                            <select name="status" onchange="this.form.submit()" class="rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                                <option value="hadir" {{ $absen && $absen->status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="izin" {{ $absen && $absen->status === 'izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="sakit" {{ $absen && $absen->status === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="alpha" {{ $absen && $absen->status === 'alpha' ? 'selected' : '' }}>Alpha</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="time" name="jam_masuk" value="{{ $absen->jam_masuk ?? '' }}" class="rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="time" name="jam_keluar" value="{{ $absen->jam_keluar ?? '' }}" class="rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="submit" class="flex items-center gap-1.5 text-violet-500 hover:text-violet-600 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                            </svg>
                                            Simpan
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center text-gray-400 gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-3.999-4A4 4 0 0015 11z" />
                                        </svg>
                                        <p class="text-sm">Belum ada data karyawan aktif</p>
                                        <a href="{{ route('karyawan.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Tambah karyawan dulu</a>
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
                @forelse($karyawans as $karyawan)
                    @php
                        $absen = $absensis->firstWhere('karyawan_id', $karyawan->id);
                        $statusColor = match($absen->status ?? 'hadir') {
                            'hadir' => 'bg-green-500',
                            'izin' => 'bg-blue-400',
                            'sakit' => 'bg-yellow-500',
                            'alpha' => 'bg-red-500',
                            default => 'bg-gray-400',
                        };
                    @endphp
                    <form action="{{ route('absensi.store') }}" method="POST" class="bg-white rounded-2xl shadow-xs p-4">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm shrink-0">
                                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $karyawan->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $karyawan->jabatan }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 border-t border-gray-100 pt-3">
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Status</label>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $statusColor }} shrink-0"></span>
                                    <select name="status" class="w-full rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                        <option value="hadir" {{ $absen && $absen->status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ $absen && $absen->status === 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="sakit" {{ $absen && $absen->status === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="alpha" {{ $absen && $absen->status === 'alpha' ? 'selected' : '' }}>Alpha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Jam Masuk</label>
                                    <input type="time" name="jam_masuk" value="{{ $absen->jam_masuk ?? '' }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Jam Keluar</label>
                                    <input type="time" name="jam_keluar" value="{{ $absen->jam_keluar ?? '' }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-violet-500 focus:ring-violet-500">
                                </div>
                            </div>
                            <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-violet-50 text-violet-500 py-2 rounded-xl text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                @empty
                    <div class="bg-white rounded-2xl shadow-xs p-8 text-center">
                        <p class="text-sm text-gray-400 mb-2">Belum ada data karyawan aktif</p>
                        <a href="{{ route('karyawan.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Tambah karyawan dulu</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>