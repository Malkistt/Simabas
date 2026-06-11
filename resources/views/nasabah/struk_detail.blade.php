<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; padding: 40px 15px; }
        .struk-container { max-width: 500px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .brand-section { text-align: center; border-bottom: 2px dashed #e5e7eb; padding-bottom: 20px; margin-bottom: 20px; }
        .brand-logo { width: 45px; height: 45px; background-color: #1b4332; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 10px; }
        
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem; }
        .detail-label { color: #6b7280; }
        .detail-value { font-weight: 500; color: #111827; }
        
        .amount-box { background-color: #f9fafb; border-radius: 10px; padding: 15px; text-align: center; margin: 20px 0; border: 1px solid #f3f4f6; }
        .amount-title { font-size: 0.8rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }
        .amount-value { font-size: 1.6rem; font-weight: 700; }
        .amount-setor { color: #15803d; }
        .amount-tarik { color: #dc2626; }

        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: #1b4332; text-decoration: none; font-weight: 600; font-size: 0.85rem; margin-bottom: 20px; }
        .btn-back:hover { color: #112a1f; }
        
        @media print {
            body { background-color: #ffffff; padding: 0; }
            .struk-container { border: none; box-shadow: none; padding: 0; }
            .btn-actions, .btn-back { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="max-width: 500px; margin: 0 auto;">
            <a href="{{ route('riwayat.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>

            <div class="struk-container">
                <div class="brand-section">
                    <div class="brand-logo"><i class="bi bi-leaf"></i></div>
                    <h5 class="fw-bold m-0" style="color: #1b4332;">SIMABAS</h5>
                    <small class="text-muted">Bukti Transaksi Digital Bank Sampah</small>
                </div>

                <div class="amount-box">
                    <div class="amount-title">Total Nilai Transaksi</div>
                    @if($transaksi->tipe_transaksi == 'setoran')
                        <div class="amount-value amount-setor">+Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</div>
                    @else
                        <div class="amount-value amount-tarik">-Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</div>
                    @endif
                </div>

                <div class="detail-row">
                    <span class="detail-label">Nomor Transaksi</span>
                    <span class="detail-value fw-bold">#TRX-{{ date('Y', strtotime($transaksi->tgl_transaksi)) }}-{{ str_pad($transaksi->id_transaksi ?? $transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Aktivitas</span>
                    <span class="detail-value text-capitalize">
                        <span class="badge {{ $transaksi->tipe_transaksi == 'setoran' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                            {{ $transaksi->tipe_transaksi }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Waktu Transaksi</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Nasabah</span>
                    <span class="detail-value">{{ $transaksi->nama_nasabah }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value text-secondary">{{ $transaksi->keterangan ?? '-' }}</span>
                </div>

                <div class="row g-2 mt-4 btn-actions">
                    <div class="col-12">
                        <button onclick="window.print()" class="btn w-100 text-white py-2" style="background-color: #1b4332; border-radius: 8px; font-weight: 500;">
                            <i class="bi bi-printer me-1"></i> Cetak Dokumen Struk
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>