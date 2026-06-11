<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1b4332; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #1b4332; }
        .header p { margin: 5px 0 0 0; font-size: 14px; }
        
        .summary { width: 100%; margin-bottom: 20px; }
        .summary td { padding: 10px; background-color: #f3f4f6; border: 1px solid #ddd; text-align: center; }
        .summary strong { display: block; font-size: 10px; color: #666; margin-bottom: 5px; }
        .summary span { font-size: 16px; font-weight: bold; color: #111; }
        
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data th { background-color: #1b4332; color: white; font-size: 11px; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SIMABAS - Laporan Transaksi Bank Sampah</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($dari_tanggal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($sampai_tanggal)->format('d M Y') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <strong>TOTAL SETORAN</strong>
                <span>Rp {{ number_format($ringkasan->total_setoran ?? 0, 0, ',', '.') }}</span>
            </td>
            <td>
                <strong>TOTAL PENARIKAN</strong>
                <span>Rp {{ number_format($ringkasan->total_penarikan ?? 0, 0, ',', '.') }}</span>
            </td>
            <td>
                <strong>JML TRANSAKSI</strong>
                <span>{{ number_format($ringkasan->jml_transaksi ?? 0, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th class="text-center">TANGGAL</th>
                <th class="text-right">SETORAN</th>
                <th class="text-right">PENARIKAN</th>
                <th class="text-right">SALDO AKHIR</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan_harian as $row)
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($row->setoran, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($row->penarikan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($row->saldo_akhir, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>