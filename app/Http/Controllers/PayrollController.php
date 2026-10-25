<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));

        $payrolls = Payroll::with('karyawan')
            ->where('periode', $periode)
            ->get();

        return view('payroll.index', compact('payrolls', 'periode'));
    }

    public function generate(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $periode);

        $karyawans = Karyawan::where('status', 'aktif')->get();

        foreach ($karyawans as $karyawan) {
            $absensiBulan = Absensi::where('karyawan_id', $karyawan->id)
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();

            $jumlahHadir = $absensiBulan->where('status', 'hadir')->count();
            $jumlahIzin = $absensiBulan->where('status', 'izin')->count();
            $jumlahAlpha = $absensiBulan->where('status', 'alpha')->count();

            if ($karyawan->tipe_gaji === 'harian') {
                $totalGaji = $karyawan->gaji_pokok * $jumlahHadir;
            } else {
                $potonganAlpha = $jumlahAlpha * 50000;
                $totalGaji = $karyawan->gaji_pokok - $potonganAlpha;
            }

            Payroll::updateOrCreate(
                ['karyawan_id' => $karyawan->id, 'periode' => $periode],
                [
                    'jumlah_hadir' => $jumlahHadir,
                    'jumlah_izin' => $jumlahIzin,
                    'jumlah_alpha' => $jumlahAlpha,
                    'gaji_pokok' => $karyawan->gaji_pokok,
                    'bonus' => 0,
                    'potongan' => $karyawan->tipe_gaji === 'bulanan' ? ($jumlahAlpha * 50000) : 0,
                    'total_gaji' => max($totalGaji, 0),
                    'status' => 'draft',
                ]
            );
        }

        return redirect()->route('payroll.index', ['periode' => $periode])->with('success', 'Payroll berhasil digenerate.');
    }

    public function bayar(Payroll $payroll)
    {
        $payroll->update([
            'status' => 'dibayar',
            'tanggal_dibayar' => now(),
        ]);

        return redirect()->back()->with('success', 'Gaji berhasil ditandai dibayar.');
    }
}