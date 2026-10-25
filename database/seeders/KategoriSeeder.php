<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Penjualan', 'tipe' => 'masuk'],
            ['nama' => 'Pendapatan Lain', 'tipe' => 'masuk'],
            ['nama' => 'Belanja Stok', 'tipe' => 'keluar'],
            ['nama' => 'Gaji Karyawan', 'tipe' => 'keluar'],
            ['nama' => 'Operasional', 'tipe' => 'keluar'],
            ['nama' => 'Listrik & Air', 'tipe' => 'keluar'],
            ['nama' => 'Sewa Tempat', 'tipe' => 'keluar'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}