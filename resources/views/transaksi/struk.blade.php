<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .struk { width: 200px; }
        .header { text-align: center; margin-bottom: 10px; }
        .line { border-bottom: 1px dashed #000; margin: 5px 0; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="struk">
        <div class="header">
            <strong>BANK SAMPAH SIMABAS</strong><br>
            Bojongsoang, Bandung
        </div>
        <div class="line"></div>
        <p>Tanggal: {{ $transaksi->tanggal }}</p>
        <p>Nasabah: {{ $transaksi->nasabah->user->nama }}</p>
        <div class="line"></div>
        
        <p>Jenis: {{ $transaksi->detailSetoran[0]->jenisSampah->nama_jenis }}</p>
        <p>Berat: {{ $transaksi->total_berat }} Kg</p>
        <p>Total: Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</p>
        
        <div class="line"></div>
        <p style="text-align:center;">Terima Kasih!</p>
    </div>
</body>
</html>