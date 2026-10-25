<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::where('status', 'aktif')->count();

        $hadirHariIni = Absensi::whereDate('tanggal', today())
            ->where('status', 'hadir')
            ->count();

        $kasMasuk = Transaksi::where('tipe', 'masuk')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        $kasKeluar = Transaksi::where('tipe', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        $aktivitasTerbaru = Transaksi::with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $chartLabels[] = $bulan->translatedFormat('M Y');

            $chartMasuk[] = Transaksi::where('tipe', 'masuk')
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->sum('nominal');

            $chartKeluar[] = Transaksi::where('tipe', 'keluar' )
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->sum('nominal');
        }

        $breakdownKategori = Transaksi::selectRaw('kategori_id, tipe, SUM(nominal) as total')
        ->with('kategori')
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->where('tipe', 'keluar')
        ->groupBy('kategori_id', 'tipe')
        ->get();

        $breakdownLabels = $breakdownKategori->map(fn($item) => $item->kategori->nama ?? 'Lainnya');
        $breakdownData = $breakdownKategori->pluck('total');

        return view('dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'kasMasuk',
            'kasKeluar',
            'aktivitasTerbaru',
            'chartLabels',
            'chartMasuk',
            'chartKeluar',
            'breakdownLabels',
            'breakdownData'
        ));
    }
}