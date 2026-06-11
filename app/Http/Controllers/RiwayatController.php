<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Nasabah dari pengguna yang sedang login
        $id_nasabah = Auth::user()->id_nasabah;

        // 2. Ambil data transaksi khusus nasabah ini
        // UBAH: Menggunakan 'tb_pengguna.id_pengguna' sebagai target ON join
        $riwayat = DB::table('tb_transaksi')
            ->leftJoin('tb_pengguna', 'tb_transaksi.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->where('tb_transaksi.id_nasabah', $id_nasabah)
            ->select(
                'tb_transaksi.*',
                'tb_pengguna.username as nama_petugas'
            )
            ->orderBy('tb_transaksi.tgl_transaksi', 'desc')
            ->get(); // Kita gunakan get() agar data bisa dikelompokkan berdasarkan bulan di Blade

        // 3. Arahkan ke view riwayat nasabah
        return view('nasabah.riwayat', compact('riwayat'));
    }
    public function detail($id)
    {
        $id_nasabah = Auth::user()->id_nasabah;

        // Ambil data transaksi berdasarkan ID dan pastikan itu milik nasabah yang sedang login
        $transaksi = DB::table('tb_transaksi')
            ->leftJoin('tb_nasabah', 'tb_transaksi.id_nasabah', '=', 'tb_nasabah.id_nasabah')
            ->leftJoin('tb_pengguna', 'tb_transaksi.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->where('tb_transaksi.id_transaksi', $id) // Sesuaikan jika primary key Anda bernama id_transaksi atau id
            ->where('tb_transaksi.id_nasabah', $id_nasabah)
            ->select(
                'tb_transaksi.*',
                'tb_nasabah.nama as nama_nasabah',
                'tb_pengguna.username as nama_petugas'
            )
            ->first();

        // Jika data transaksi tidak ditemukan atau bukan milik nasabah tersebut, kembalikan dengan error
        if (!$transaksi) {
            return redirect()->route('nasabah.riwayat')->with('error', 'Detail transaksi tidak ditemukan.');
        }

        // Tampilkan halaman struk detail transaksi khusus nasabah
        return view('nasabah.struk_detail', compact('transaksi'));
    }
}