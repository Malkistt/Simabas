<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Setoran (Hanya tipe_transaksi = 'setoran')
        $total_setoran = DB::table('tb_transaksi')
            ->where('tipe_transaksi', 'setoran')
            ->sum('total_nilai');

        // 2. Hitung Jumlah Nasabah Terdaftar
        $total_nasabah = DB::table('tb_nasabah')->count();

        // 3. Hitung Jumlah Seluruh Transaksi
        $total_transaksi = DB::table('tb_transaksi')->count();

        // 4. Ambil 5 Transaksi Terakhir (Untuk List Tabel di Bawah)
        $transaksi_terakhir = DB::table('tb_transaksi')
            ->join('tb_nasabah', 'tb_transaksi.id_nasabah', '=', 'tb_nasabah.id_nasabah')
            ->select('tb_transaksi.*', 'tb_nasabah.nama as nama_nasabah')
            ->orderBy('tgl_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Kirim semua variabel ke tampilan view dashboard
        return view('petugas.dashboard', compact(
            'total_setoran', 
            'total_nasabah', 
            'total_transaksi', 
            'transaksi_terakhir'
        ));
    }
}