<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['kategori', 'user']);

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $transaksis = $query->latest('tanggal')->paginate(15);

        return response()->json([
            'status' => true,
            'message' => 'Daftar Transaksi',
            'data' => $transaksis
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategoris,id',
            'tipe' => 'required|in:masuk,keluar',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $validated['user_id'] = auth()->id();

        $transaksi = Transaksi::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil dicatat.',
            'data' => $transaksi
        ], 201);
    }

    public function update(Request $request, $id)
    {
    $transaksi = Transaksi::find($id);

    if (!$transaksi) {
        return response()->json(['status' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
    }

    $validator = Validator::make($request->all(), [
        'kategori_id' => 'required|exists:kategoris,id',
        'tipe'        => 'required|in:masuk,keluar',
        'nominal'     => 'required|numeric',
        'tanggal'     => 'required|date',
        'keterangan'  => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    }

    $transaksi->update($validator->validated());

    return response()->json([
        'status'  => true,
        'message' => 'Transaksi berhasil diupdate.',
        'data'    => $transaksi
    ], 200);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['status' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $transaksi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil dihapus.'
        ], 200);
    }
}