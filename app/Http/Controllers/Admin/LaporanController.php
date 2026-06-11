<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Import Facade PDF

class LaporanController extends Controller
{
    private function getLaporanData(Request $request)
    {
        // Set default filter ke bulan ini jika tidak ada input
        $dari_tanggal = $request->dari_tanggal ?? date('Y-m-01');
        $sampai_tanggal = $request->sampai_tanggal ?? date('Y-m-t');

        // 1. Hitung Ringkasan (Total Setoran, Penarikan, Jml Transaksi)
        $ringkasan = DB::table('tb_transaksi')
            ->whereDate('tgl_transaksi', '>=', $dari_tanggal)
            ->whereDate('tgl_transaksi', '<=', $sampai_tanggal)
            ->selectRaw("
                SUM(CASE WHEN tipe_transaksi = 'setoran' THEN total_nilai ELSE 0 END) as total_setoran,
                SUM(CASE WHEN tipe_transaksi = 'penarikan' THEN total_nilai ELSE 0 END) as total_penarikan,
                COUNT(id_transaksi) as jml_transaksi
            ")->first();

        // 2. Hitung Saldo Awal (Sebelum 'dari_tanggal')
        $saldo_awal = DB::table('tb_transaksi')
            ->whereDate('tgl_transaksi', '<', $dari_tanggal)
            ->selectRaw("SUM(CASE WHEN tipe_transaksi = 'setoran' THEN total_nilai ELSE -total_nilai END) as saldo")
            ->value('saldo') ?? 0;

        // 3. Rekap Transaksi Harian
        $laporan_harian = DB::table('tb_transaksi')
            ->select(DB::raw('DATE(tgl_transaksi) as tanggal'),
                     DB::raw("SUM(CASE WHEN tipe_transaksi = 'setoran' THEN total_nilai ELSE 0 END) as setoran"),
                     DB::raw("SUM(CASE WHEN tipe_transaksi = 'penarikan' THEN total_nilai ELSE 0 END) as penarikan"))
            ->whereDate('tgl_transaksi', '>=', $dari_tanggal)
            ->whereDate('tgl_transaksi', '<=', $sampai_tanggal)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // 4. Hitung Saldo Akhir Berjalan per Hari
        $saldo_berjalan = $saldo_awal;
        foreach ($laporan_harian as $row) {
            $saldo_berjalan += $row->setoran - $row->penarikan;
            $row->saldo_akhir = $saldo_berjalan;
        }

        return compact('dari_tanggal', 'sampai_tanggal', 'ringkasan', 'laporan_harian');
    }

    // Tampilkan Halaman Web
    public function index(Request $request)
    {
        $data = $this->getLaporanData($request);
        return view('admin.laporan', $data);
    }

    // Download format PDF
    public function cetakPdf(Request $request)
    {
        $data = $this->getLaporanData($request);
        
        // Load view khusus PDF
        $pdf = Pdf::loadView('admin.laporan_pdf', $data);
        
        // Nama file PDF yang di-download
        return $pdf->download('Laporan_Transaksi_SIMABAS_' . $data['dari_tanggal'] . '_sd_' . $data['sampai_tanggal'] . '.pdf');
    }
}