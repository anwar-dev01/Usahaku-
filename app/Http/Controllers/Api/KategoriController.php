<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // 1. GET ALL
    public function index()
    {
        $kategoris = Kategori::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar Kategori',
            'data' => $kategoris
        ], 200);
    }

    // 2. CREATE (POST)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:masuk,keluar',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $kategori = Kategori::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $kategori
        ], 201);
    }

    // 3. GET DETAIL (SHOW) -> INI YANG TADI KETINGGALAN!
    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail Kategori',
            'data' => $kategori
        ], 200);
    }

    // 4. UPDATE (PUT)
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['status' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:masuk,keluar',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $kategori->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil diupdate.',
            'data' => $kategori
        ], 200);
    }

    // 5. DELETE
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['status' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
        }

        if ($kategori->transaksis()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori tidak bisa dihapus karena masih dipakai transaksi.'
            ], 400);
        }

        $kategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil dihapus.'
        ], 200);
    }
}