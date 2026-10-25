<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-xl text-slate-900">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-1">Isi data di bawah untuk mulai menggunakan Usahaku</p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name" placeholder="Nama kamu"
                class="w-full rounded-lg border-slate-200 focus:border-blue-700 focus:ring-blue-700 text-sm" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username" placeholder="nama@email.com"
                class="w-full rounded-lg border-slate-200 focus:border-blue-700 focus:ring-blue-700 text-sm" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full rounded-lg border-slate-200 focus:border-blue-700 focus:ring-blue-700 text-sm" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Ulangi password"
                class="w-full rounded-lg border-slate-200 focus:border-blue-700 focus:ring-blue-700 text-sm" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-blue-700 hover:underline">
                Sudah punya akun?
            </a>

            <button type="submit"
                class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
                Daftar Gratis
            </button>
        </div>
    </form>
</x-guest-layout>