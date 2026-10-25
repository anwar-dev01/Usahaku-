<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;

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

    $transaksis = $query->latest('tanggal')->paginate(15)->withQueryString();
    $kategoris = Kategori::all();

    return view('transaksi.index', compact('transaksis', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('transaksi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'tipe' => 'required|in:masuk,keluar',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function exportexel(Request $request)
    {
    $bulan = $request->input('bulan', now()->month);
    $tahun = $request->input('tahun', now()->year);

    $namaBulan = \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F-Y');

    return Excel::download(new TransaksiExport($bulan, $tahun), "laporan-transaksi-{$namaBulan}.xlsx");
    }

    public function exportPdf(Request $request)
    {
    $bulan = $request->input('bulan', now()->month);
    $tahun = $request->input('tahun', now()->year);

    $transaksis = Transaksi::with(['kategori', 'user'])
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal')
        ->get();

    $totalMasuk = $transaksis->where('tipe', 'masuk')->sum('nominal');
    $totalKeluar = $transaksis->where('tipe', 'keluar')->sum('nominal');

    $namaBulan = \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y');

    $pdf = Pdf::loadView('transaksi.pdf', compact('transaksis', 'totalMasuk', 'totalKeluar', 'namaBulan'));

    return $pdf->download("laporan-transaksi-{$namaBulan}.pdf");
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}