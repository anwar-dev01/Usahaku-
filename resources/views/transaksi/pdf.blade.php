<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 0; color: #6d28d9; }
        p.subtitle { margin-top: 4px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #6d28d9; color: white; }
        .text-right { text-align: right; }
        .masuk { color: #16a34a; }
        .keluar { color: #dc2626; }
        .summary { margin-top: 20px; width: 300px; float: right; }
        .summary td { border: none; padding: 4px 8px; }
    </style>
</head>
<body>
    <h2>Usahaku</h2>
    <p class="subtitle">Laporan Transaksi Keuangan - {{ $namaBulan }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th class="text-right">Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
                <tr>
                    <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                    <td>{{ $t->kategori->nama }}</td>
                    <td>{{ ucfirst($t->tipe) }}</td>
                    <td class="text-right {{ $t->tipe === 'masuk' ? 'masuk' : 'keluar' }}">
                        Rp {{ number_format($t->nominal, 0, ',', '.') }}
                    </td>
                    <td>{{ $t->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada transaksi bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td>Total Kas Masuk</td>
            <td class="text-right masuk">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Kas Keluar</td>
            <td class="text-right keluar">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Saldo</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>