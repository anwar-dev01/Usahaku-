<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Keuangan / Transaksi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-4 md:items-center">
                <div class="bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl shadow-xs p-6 text-white flex-1 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Total Transaksi: {{ $transaksis->total() }}</h3>
                    <svg class="w-8 h-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="grid grid-cols-3 md:flex gap-2">
                    <a href="{{ route('transaksi.exportexel', ['bulan' => now()->month, 'tahun' => now()->year]) }}" class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-3 md:px-5 py-3 rounded-xl font-medium transition-colors text-sm md:text-base">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('transaksi.export.pdf', ['bulan' => now()->month, 'tahun' => now()->year]) }}" class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white px-3 md:px-5 py-3 rounded-xl font-medium transition-colors text-sm md:text-base">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        PDF
                    </a>
                    <a href="{{ route('transaksi.create') }}" class="flex items-center justify-center gap-2 bg-violet-500 hover:bg-violet-600 text-white px-3 md:px-5 py-3 rounded-xl font-medium transition-colors shadow-xs text-sm md:text-base">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Catat
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xs p-4">
                <form method="GET" class="flex flex-wrap gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..." class="flex-1 min-w-[180px] rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500 text-sm">
                    <select name="tipe" onchange="this.form.submit()" class="rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500 text-sm">
                        <option value="">Semua Tipe</option>
                        <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Kas Masuk</option>
                        <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Kas Keluar</option>
                    </select>
                    <select name="kategori_id" onchange="this.form.submit()" class="rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500 text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-violet-500 hover:bg-violet-600 text-white px-4 py-2 rounded-xl text-sm font-medium">Cari</button>
                    @if(request('search') || request('tipe') || request('kategori_id'))
                        <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-gray-700 px-4 py-2 text-sm">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Versi Tabel (Desktop) -->
            <div class="hidden md:block bg-white rounded-2xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Nominal</th>
                            <th class="px-6 py-3">Dicatat Oleh</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transaksis as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-500">{{ $t->tanggal->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $t->kategori->nama }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $t->tipe === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $t->tipe === 'masuk' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ ucfirst($t->tipe) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium font-mono {{ $t->tipe === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $t->user->name }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('transaksi.destroy', $t) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center text-gray-400 gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm">Belum ada transaksi tercatat</p>
                                        <a href="{{ route('transaksi.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Catat transaksi pertama</a>
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
                @forelse($transaksis as $t)
                    <div class="bg-white rounded-2xl shadow-xs p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $t->kategori->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $t->tanggal->format('d M Y') }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $t->tipe === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $t->tipe === 'masuk' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ ucfirst($t->tipe) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                            <p class="font-semibold font-mono text-lg {{ $t->tipe === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </p>
                            <form action="{{ route('transaksi.destroy', $t) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-red-500 bg-red-50" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Dicatat oleh {{ $t->user->name }}</p>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-xs p-8 text-center">
                        <p class="text-sm text-gray-400 mb-2">Belum ada transaksi tercatat</p>
                        <a href="{{ route('transaksi.create') }}" class="text-violet-500 hover:underline text-xs font-medium">+ Catat transaksi pertama</a>
                    </div>
                @endforelse
            </div>

            <div>{{ $transaksis->links() }}</div>

        </div>
    </div>
</x-app-layout>