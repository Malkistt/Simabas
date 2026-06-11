<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Struk Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; padding: 0; }
        
        /* SIDEBAR */
        .sidebar { background-color: #ffffff; width: 250px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .brand-icon { width: 35px; height: 35px; background-color: #15803d; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: white; }
        .menu-container { padding: 15px 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #6c757d; text-decoration: none; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
        .menu-item.active { background-color: #f0fdf4; color: #15803d; border-left-color: #15803d; font-weight: 600; }
        
        /* MAIN CONTENT */
        .main-wrapper { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #ffffff; height: 75px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 999; }
        
        .content { padding: 30px; display: flex; justify-content: center; }

        /* DESAIN STRUK (Sesuai Figma) */
        .receipt-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); width: 100%; max-width: 550px; }
        
        .alert-success-custom { background-color: #dcfce7; color: #166534; text-align: center; font-weight: 600; padding: 12px; border-radius: 8px; font-size: 0.95rem; margin-bottom: 20px; }

        .receipt-paper { background: #ffffff; border: 2px dashed #d1d5db; border-radius: 12px; padding: 35px; font-family: 'Courier New', Courier, monospace; color: #374151; font-size: 0.95rem; }
        
        .receipt-header { text-align: center; margin-bottom: 20px; }
        .receipt-title { font-weight: 700; font-size: 1.25rem; letter-spacing: 2px; margin-bottom: 5px; color: #111827;}
        .receipt-subtitle { color: #6b7280; font-size: 0.85rem; line-height: 1.4; }
        
        .divider { border-top: 1px dashed #9ca3af; margin: 15px 0; text-align: center; position: relative; }
        .divider span { background: #ffffff; padding: 0 10px; position: relative; top: -10px; font-weight: 600; font-size: 0.9rem; }

        .info-row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .item-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        
        .total-row { display: flex; justify-content: space-between; font-weight: 700; font-size: 1.1rem; margin-top: 15px; margin-bottom: 15px; color: #111827; }
        
        .receipt-footer { text-align: center; margin-top: 30px; font-size: 0.8rem; color: #9ca3af; line-height: 1.5; }

        /* BUTTONS */
        .btn-outline-green { background-color: #ffffff; color: #15803d; border: 1px solid #15803d; padding: 10px; border-radius: 8px; font-weight: 600; width: 100%; text-decoration: none; display: block; text-align: center; transition: 0.2s;}
        .btn-outline-green:hover { background-color: #f0fdf4; color: #166534; }
        .btn-solid-green { background-color: #15803d; color: #ffffff; border: none; padding: 10px; border-radius: 8px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-solid-green:hover { background-color: #166534; }

        /* CSS KHUSUS SAAT DICETAK (PRINT) */
        @media print {
            body { background-color: #ffffff; }
            .sidebar, .topbar, .alert-success-custom, .btn-action-area { display: none !important; }
            .main-wrapper { margin-left: 0; }
            .content { padding: 0; }
            .receipt-card { border: none; box-shadow: none; max-width: 100%; }
            .receipt-paper { border: none; padding: 0; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="brand-icon"><i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i></div>
            <div style="line-height: 1.2;">
                <div style="font-weight: 700; color: #15803d; font-size: 1.1rem;">SIMABAS</div>
            </div>
        </div>
        <div class="menu-container">
            <a href="{{ url('/dashboard') }}" class="menu-item"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
            <a href="{{ route('nasabah.index') }}" class="menu-item"><i class="bi bi-people"></i> Data Nasabah</a>
            <a href="{{ route('transaksi.create') }}" class="menu-item active"><i class="bi bi-recycle"></i> Setor Sampah</a>
            <a href="#" class="menu-item"><i class="bi bi-wallet2"></i> Tarik Saldo</a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <h4 class="m-0" style="font-size: 1.1rem; color: #111827; font-weight: 700;">Struk Transaksi</h4>
            <button onclick="window.print()" class="btn btn-sm btn-solid-green" style="width: auto; padding: 6px 15px;">
                <i class="bi bi-printer-fill me-1"></i> Cetak
            </button>
        </div>

        <div class="content">
            <div class="receipt-card">
                
                @if(session('success'))
                <div class="alert-success-custom">
                    <i class="bi bi-check-lg me-1"></i> {{ session('success') }}
                </div>
                @endif

                <div class="receipt-paper" id="area-struk">
                    
                    <div class="receipt-header">
                        <div class="receipt-title">SIMABAS</div>
                        <div class="receipt-subtitle">
                            Bank Sampah UIN SGD Bandung<br>
                            Jl. A.H. Nasution No. 105
                        </div>
                    </div>

                    <div class="divider"><span>STRUK SETORAN SAMPAH</span></div>

                    <div class="info-row">
                        <span>No. Transaksi</span>
                        <span style="font-weight: 600;">#TRX-{{ date('Y', strtotime($transaksi->tgl_transaksi)) }}-{{ str_pad($transaksi->id_transaksi ?? $transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-row">
                        <span>Tanggal</span>
                        <span id="waktuSistemWindows">加载...</span>
                    </div>
                    <div class="info-row">
                        <span>Petugas</span>
                        <span>{{ $transaksi->nama_petugas }}</span>
                    </div>
                    <div class="info-row">
                        <span>Nasabah</span>
                        <span>{{ $transaksi->nama_nasabah }}</span>
                    </div>

                    <div class="divider" style="margin-top: 20px;"></div>

                    <div style="margin-bottom: 10px; font-weight: 600;">Detail Setoran:</div>
                    
                    @if(count($detail_struk) > 0)
                        @foreach($detail_struk as $item)
                        <div class="item-row">
                            <span style="width: 50%;">{{ $item['kategori'] }} {{ $item['berat'] }} kg</span>
                            <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    @else
                        <div class="item-row">
                            <span style="width: 50%;">Setoran Sampah Campur</span>
                            <span>Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="item-row" style="margin-top: 10px; font-weight: 600;">
                        <span style="width: 50%;">Total Berat</span>
                        <span>{{ $total_berat > 0 ? $total_berat : '-' }} kg</span>
                    </div>

                    <div class="total-row">
                        <span>TOTAL NILAI</span>
                        <span>Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</span>
                    </div>

                    <div class="info-row">
                        <span>Saldo Sebelum</span>
                        <span>Rp {{ number_format($saldo_sebelum, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span>Saldo Sekarang</span>
                        <span style="font-weight: 600;">Rp {{ number_format($saldo_sekarang, 0, ',', '.') }}</span>
                    </div>

                    <div class="receipt-footer">
                        Terima kasih telah menabung sampah!<br>
                        Bersama kita jaga lingkungan. <i class="bi bi-recycle" style="color: #166534;"></i>
                    </div>

                </div>

                <div class="row mt-4 btn-action-area">
                    <div class="col-6">
                        <button onclick="downloadPDF()" class="btn-outline-green" style="border: 1px solid #15803d; width: 100%; padding: 10px; border-radius: 8px;">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Simpan PDF
                        </button>
                    </div>
                    <div class="col-6">
                        <button onclick="window.print()" class="btn-solid-green"><i class="bi bi-printer-fill me-1"></i> Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function downloadPDF() {
    // 1. Ambil elemen struk berdasarkan ID yang kita buat tadi
    var element = document.getElementById('area-struk');
    
    // 2. Ambil nomor transaksi untuk nama file (Contoh: #TRX-2026-0005)
    var noTrx = "#TRX-{{ date('Y', strtotime($transaksi->tgl_transaksi)) }}-{{ str_pad($transaksi->id_transaksi ?? $transaksi->id, 4, '0', STR_PAD_LEFT) }}";
    var namaFile = "Struk_Setoran_Sampah_" + noTrx.replace('#', '') + ".pdf";

    // 3. Atur konfigurasi output PDF agar rapi dan pas dengan ukuran kertas struk
    var opt = {
        margin:       10,
        filename:     namaFile,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true }, // Menggunakan scale 2 agar tulisan tajam tidak pecah
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // 4. Eksekusi perintah download otomatis
    html2pdf().set(opt).from(element).save();
}

    // LOGIKA MENYAMAKAN WAKTU DENGAN SISTEM WINDOWS
    document.addEventListener("DOMContentLoaded", function() {
        var sekarang = new Date();
        
        // Mengambil komponen tanggal lokal komputer
        var tgl = String(sekarang.getDate()).padStart(2, '0');
        var bln = String(sekarang.getMonth() + 1).padStart(2, '0'); // Januari adalah 0
        var thn = sekarang.getFullYear();
        
        // Mengambil komponen jam dan menit lokal komputer Windows
        var jam = String(sekarang.getHours()).padStart(2, '0');
        var menit = String(sekarang.getMinutes()).padStart(2, '0');
        
        // Format gabungan: DD/MM/YYYY HH:mm (Contoh: 09/06/2026 14:05)
        var waktuFormatLokal = tgl + '/' + bln + '/' + thn + ' ' + jam + ':' + menit;
        
        // Pasang hasil ke dalam elemen struk
        document.getElementById('waktuSistemWindows').innerText = waktuFormatLokal;
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>