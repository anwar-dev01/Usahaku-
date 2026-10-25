<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Data Karyawan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center">
                <div class="bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl shadow-xs p-6 text-white flex-1 mr-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Total Karyawan: {{ $karyawans->total() }}</h3>
                    <svg class="w-8 h-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-3.999-4A4 4 0 0015 11z" />
                    </svg>
                </div>
                <a href="{{ route('karyawan.create') }}" class="flex items-center gap-2 bg-violet-500 hover:bg-violet-600 text-white px-5 py-3 rounded-xl font-medium whitespace-nowrap transition-colors shadow-xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Karyawan
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xs p-4">
                <form method="GET" class="flex flex-wrap gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau jabatan..." class="flex-1 min-w-[200px] rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500 text-sm">
                    <select name="status" onchange="this.form.submit()" class="rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <button type="submit" class="bg-violet-500 hover:bg-violet-600 text-white px-4 py-2 rounded-xl text-sm font-medium">Cari</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('karyawan.index') }}" class="text-gray-500 hover:text-gray-700 px-4 py-2 text-sm">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Versi Tabel (Desktop) -->
            <div class="hidden md:block bg-white rounded-2xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Jabatan</th>
                            <th class="px-6 py-3">Tipe Gaji</th>
                            <th class="px-6 py-3">Gaji Pokok</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($karyawans as $karyawan)
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
                                <td class="px-6 py-4 text-gray-500 capitalize">{{ $karyawan->tipe_gaji }}</td>
                                <td class="px-6 py-4 text-gray-500 font-mono">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $karyawan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $karyawan->status === 'aktif' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ ucfirst($karyawan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('karyawan.edit', $karyawan) }}" class="p-1.5 rounded-lg text-violet-500 hover:bg-violet-50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('karyawan.destroy', $karyawan) }}" method="POST" onsubmit="return confirm('Yakin hapus karyawan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center text-gray-400 gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-3.999-4A4 4 0 0015 11z" />
                                        </svg>
                                        <p class="text-sm">Belum ada data karyawan</p>
                                        <a href="{{ route('karyawan.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Tambah karyawan pertama</a>
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
                    <div class="bg-white rounded-2xl shadow-xs p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm shrink-0">
                                    {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $karyawan->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $karyawan->jabatan }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $karyawan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $karyawan->status === 'aktif' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ ucfirst($karyawan->status) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm border-t border-gray-100 pt-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-400">Tipe Gaji</p>
                                <p class="text-gray-700 capitalize">{{ $karyawan->tipe_gaji }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Gaji Pokok</p>
                                <p class="text-gray-700 font-mono">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 border-t border-gray-100 pt-3">
                            <a href="{{ route('karyawan.edit', $karyawan) }}" class="flex-1 text-center py-2 rounded-xl text-violet-500 bg-violet-50 text-sm font-medium">Edit</a>
                            <form action="{{ route('karyawan.destroy', $karyawan) }}" method="POST" onsubmit="return confirm('Yakin hapus karyawan ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2 rounded-xl text-red-500 bg-red-50 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-xs p-8 text-center">
                        <p class="text-sm text-gray-400 mb-2">Belum ada data karyawan</p>
                        <a href="{{ route('karyawan.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Tambah karyawan pertama</a>
                    </div>
                @endforelse
            </div>

            <div>{{ $karyawans->links() }}</div>

        </div>
    </div>
</x-app-layout>