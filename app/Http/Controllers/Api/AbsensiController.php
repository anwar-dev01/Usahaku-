<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return response()->json([
            'status' => true,
            'tanggal' => $tanggal,
            'data' => $absensis
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_keluar' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $user = auth()->user();

        if ($user->role == 'karyawan') {
            $karyawan = Karyawan::where('user_id', $user->id)->first();

            if (!$karyawan || $karyawan->id != $validated['karyawan_id']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kamu hanya bisa mengisi absensi milik sendiri.'
                ], 403);
            }
        }

        $absensi = Absensi::updateOrCreate(
            [
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $validated['tanggal'],
            ],
            $validated
        );

        return response()->json([
            'status' => true,
            'message' => 'Absensi berhasil disimpan.',
            'data' => $absensi
        ], 200);
    }

    public function destroy($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['status' => false, 'message' => 'Absensi tidak ditemukan.'], 404);
        }

        $user = auth()->user();
        if ($user->role === 'karyawan' && $absensi->karyawan->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Kamu tidak bisa menghapus absensi orang lain.'
            ], 403);
        }

        $absensi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Absensi berhasil dihapus.'
        ], 200);
    }
}