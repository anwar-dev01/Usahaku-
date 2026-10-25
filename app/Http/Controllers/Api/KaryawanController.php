<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans = $query->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Daftar Karyawan',
            'data' => $karyawans
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tipe_gaji' => 'required|in:harian,bulanan',
            'gaji_pokok' => 'required|numeric|min:0',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_masuk' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $karyawan = Karyawan::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil ditambahkan.',
            'data' => $karyawan
        ], 201);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['status' => false, 'message' => 'Karyawan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => true, 'data' => $karyawan], 200);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['status' => false, 'message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tipe_gaji' => 'required|in:harian,bulanan',
            'gaji_pokok' => 'required|numeric|min:0',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $karyawan->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil diupdate.',
            'data' => $karyawan
        ], 200);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['status' => false, 'message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $karyawan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil dihapus.'
        ], 200);
    }
}