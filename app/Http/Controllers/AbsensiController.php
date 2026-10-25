<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', today()->format('Y-m-d'));
        $user = auth()->user();

        if ($user->role === 'karyawan') {
            $karyawans = Karyawan::where('user_id', $user->id)->get();
        } else {
            $karyawans = Karyawan::where('status', 'aktif')->get();
        }

        $absensis = Absensi::with('karyawan')
            ->whereDate('tanggal', $tanggal)
            ->whereIn('karyawan_id', $karyawans->pluck('id'))
            ->get();

        return view('absensi.index', compact('absensis', 'karyawans', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_keluar' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $user = auth()->user();
        if ($user->role === 'karyawan') {
            $karyawan = Karyawan::find($validated['karyawan_id']);
            if (!$karyawan || $karyawan->user_id !== $user->id) {
                abort(403, 'Kamu hanya bisa mengisi absensi milik sendiri.');
            }
        }

        Absensi::updateOrCreate(
            [
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $validated['tanggal'],
            ],
            $validated
        );

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function destroy(Absensi $absensi)
    {
        $user = auth()->user();
        if ($user->role === 'karyawan' && $absensi->karyawan->user_id !== $user->id) {
            abort(403, 'Kamu tidak bisa menghapus absensi orang lain.');
        }

        $absensi->delete();
        return redirect()->back()->with('success', 'Absensi berhasil dihapus.');
    }
}