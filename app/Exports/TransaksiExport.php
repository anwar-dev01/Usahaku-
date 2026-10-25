<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Transaksi::with(['kategori', 'user'])
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->orderBy('tanggal')
            ->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Kategori', 'Tipe', 'Nominal', 'Keterangan', 'Dicatat Oleh'];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->tanggal->format('d-m-Y'),
            $transaksi->kategori->nama,
            ucfirst($transaksi->tipe),
            $transaksi->nominal,
            $transaksi->keterangan ?? '-',
            $transaksi->user->name,
        ];
    }
}