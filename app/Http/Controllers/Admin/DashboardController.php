<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil Statistik Angka
        $total_nasabah = DB::table('tb_nasabah')->count();
        $total_petugas = DB::table('tb_pengguna')->where('peran', 'petugas')->count();
        $total_transaksi = DB::table('tb_transaksi')->count();
        $total_saldo = DB::table('tb_saldo')->sum('saldo_tersedia');

        // Format Saldo agar menjadi "Jt" (Juta) jika lebih dari 1.000.000 seperti di Figma
        if ($total_saldo >= 1000000) {
            $format_saldo = 'Rp ' . round($total_saldo / 1000000, 1) . ' Jt';
        } else {
            $format_saldo = 'Rp ' . number_format($total_saldo, 0, ',', '.');
        }

        // 2. Mengambil 5 Transaksi Terbaru
        $transaksi_terbaru = DB::table('tb_transaksi')
            ->join('tb_nasabah', 'tb_transaksi.id_nasabah', '=', 'tb_nasabah.id_nasabah')
            ->select('tb_transaksi.*', 'tb_nasabah.nama as nama_nasabah')
            ->orderBy('tgl_transaksi', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'total_nasabah', 'total_petugas', 'total_transaksi', 'format_saldo', 'transaksi_terbaru'
        ));
    }
}