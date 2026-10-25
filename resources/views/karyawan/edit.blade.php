<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Karyawan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xs p-6">
                <form action="{{ route('karyawan.update', $karyawan) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('jabatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Gaji</label>
                        <select name="tipe_gaji" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                            <option value="harian" {{ old('tipe_gaji', $karyawan->tipe_gaji) === 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ old('tipe_gaji', $karyawan->tipe_gaji) === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                        @error('tipe_gaji') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" value="{{ old('gaji_pokok', $karyawan->gaji_pokok) }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('gaji_pokok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk->format('Y-m-d')) }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('tanggal_masuk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                            <option value="aktif" {{ old('status', $karyawan->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $karyawan->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('karyawan.index') }}" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-violet-500 hover:bg-violet-600 text-white">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>