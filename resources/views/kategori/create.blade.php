<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xs p-6">
                <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="tipe" class="w-full rounded-xl border-gray-200 focus:border-violet-500 focus:ring-violet-500">
                            <option value="masuk" {{ old('tipe') === 'masuk' ? 'selected' : '' }}>Kas Masuk</option>
                            <option value="keluar" {{ old('tipe') === 'keluar' ? 'selected' : '' }}>Kas Keluar</option>
                        </select>
                        @error('tipe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('kategori.index') }}" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-violet-500 hover:bg-violet-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>