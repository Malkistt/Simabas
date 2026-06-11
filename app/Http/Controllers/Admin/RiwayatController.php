<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar menggabungkan tabel transaksi, nasabah, dan pengguna (petugas)
        $query = DB::table('tb_transaksi')
            ->join('tb_nasabah', 'tb_transaksi.id_nasabah', '=', 'tb_nasabah.id_nasabah')
            ->leftJoin('tb_pengguna', 'tb_transaksi.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select(
                'tb_transaksi.*', 
                'tb_nasabah.nama as nama_nasabah', 
                'tb_pengguna.username as nama_petugas'
            );

        // Filter Pencarian Nama Nasabah
        if ($request->filled('cari')) {
            $query->where('tb_nasabah.nama', 'like', '%' . $request->cari . '%');
        }

        // Filter Tanggal Mulai & Akhir
        if ($request->filled('tgl_mulai')) {
            $query->whereDate('tb_transaksi.tgl_transaksi', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tb_transaksi.tgl_transaksi', '<=', $request->tgl_akhir);
        }

        // Filter Jenis Transaksi (Setoran / Penarikan)
        if ($request->filled('jenis') && $request->jenis != 'Semua') {
            $query->where('tb_transaksi.tipe_transaksi', strtolower($request->jenis));
        }

        // Eksekusi dengan Pagination (10 data per halaman)
        $riwayat = $query->orderBy('tb_transaksi.tgl_transaksi', 'desc')->paginate(10);
        
        // Mempertahankan parameter filter di URL saat pindah halaman (pagination)
        $riwayat->appends($request->all());

        return view('admin.riwayat', compact('riwayat'));
    }
}