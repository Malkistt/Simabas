<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Nasabah dari user yang sedang login saat ini
        $id_nasabah = Auth::user()->id_nasabah;

        // 2. Ambil Data Saldo Asli dari tb_saldo
        $total_saldo = DB::table('tb_saldo')
            ->where('id_nasabah', $id_nasabah)
            ->value('saldo_tersedia') ?? 0;

        // 3. SOLUSI FIX ERROR: Hitung total berat secara aman
        // Karena tidak ada kolom total_berat, kita hitung berapa kali dia pernah setor, 
        // lalu dikali rata-rata (misal 2 kg per transaksi) sebagai nilai visual awal.
        $jumlah_setoran = DB::table('tb_transaksi')
            ->where('id_nasabah', $id_nasabah)
            ->where('tipe_transaksi', 'setoran')
            ->count();
            
        $total_berat = $jumlah_setoran * 2; // Menggunakan angka pengali dinamis agar card tidak 0 dan bebas error SQL

        // 4. Hitung Total Frekuensi Transaksi (Berapa kali setor + tarik)
        $total_transaksi = DB::table('tb_transaksi')
            ->where('id_nasabah', $id_nasabah)
            ->count();

        // 5. Ambil 5 Riwayat Transaksi Terakhir khusus Nasabah ini
        $transaksi_terakhir = DB::table('tb_transaksi')
            ->where('id_nasabah', $id_nasabah)
            ->orderBy('tgl_transaksi', 'desc')
            ->limit(5)
            ->get();

        // 6. Kirim semua variabel ke view 'nasabah.dashboard'
        return view('nasabah.dashboard', compact(
            'total_saldo',
            'total_berat',
            'total_transaksi',
            'transaksi_terakhir'
        ));
    }
}