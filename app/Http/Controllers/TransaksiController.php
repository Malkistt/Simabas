<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function create()
    {
        // 1. Ambil data nasabah beserta saldo & statusnya
        $nasabah = DB::table('tb_nasabah')
            ->leftJoin('tb_pengguna', 'tb_nasabah.id_nasabah', '=', 'tb_pengguna.id_nasabah')
            ->leftJoin('tb_saldo', 'tb_nasabah.id_nasabah', '=', 'tb_saldo.id_nasabah')
            ->select('tb_nasabah.id_nasabah', 'tb_nasabah.nama', 'tb_saldo.saldo_tersedia', 'tb_pengguna.status_aktif')
            ->get();

        // 2. Ambil data jenis sampah dari database
        $jenis_sampah = DB::table('tb_jenis_sampah')->get();

        return view('petugas.transaksi.create', compact('nasabah', 'jenis_sampah'));
    }
    
    public function store(Request $request)
    {
        // 1. Validasi Input form (Bentuk Array karena bisa tambah banyak baris sampah)
        $request->validate([
            'id_nasabah' => 'required',
            'tgl_transaksi' => 'required',
            'id_jenis' => 'required|array',
            'berat' => 'required|array',
        ]);

        $id_transaksi_baru = 0;

        DB::transaction(function () use ($request, &$id_transaksi_baru) {
            $total_nilai = 0;
            $total_berat = 0;
            $detail_struk = [];

            // 2. Hitung total nilai & berat dari seluruh baris sampah yang diinput
            foreach ($request->id_jenis as $key => $id_jenis) {
                $harga = $request->harga_per_kg[$key];
                $berat = $request->berat[$key];
                $subtotal = $harga * $berat;
                
                $total_nilai += $subtotal;
                $total_berat += $berat;

                // Ambil nama kategori sampah
                $kategori = DB::table('tb_jenis_sampah')->where('id_jenis', $id_jenis)->value('kategori');
                
                $detail_struk[] = [
                    'kategori' => $kategori,
                    'berat'    => $berat,
                    'harga'    => $harga,
                    'subtotal' => $subtotal
                ];
            }

            // Ambil ID Petugas yang sedang login
            $id_petugas = auth()->user()->id_pengguna ?? auth()->user()->id ?? 2; 

            // 3. Simpan ke tabel tb_transaksi
            $id_transaksi_baru = DB::table('tb_transaksi')->insertGetId([
                'id_nasabah'     => $request->id_nasabah,
                'id_pengguna'    => $id_petugas, 
                'tgl_transaksi'  => $request->tgl_transaksi . ' ' . date('H:i:s'),
                'tipe_transaksi' => 'setoran',
                'total_nilai'    => $total_nilai,
                'keterangan'     => 'Setoran Sampah (' . $total_berat . ' kg)',
            ]);

            // 4. PENAMBAHAN SALDO NASABAH OTOMATIS
            $saldo_lama = DB::table('tb_saldo')->where('id_nasabah', $request->id_nasabah)->value('saldo_tersedia') ?? 0;
            $saldo_baru = $saldo_lama + $total_nilai;

            DB::table('tb_saldo')->where('id_nasabah', $request->id_nasabah)->update([
                'saldo_tersedia' => $saldo_baru,
                'tgl_update'     => Carbon::now()
            ]);

            // 5. Simpan Rincian ke Session agar struk HTML bisa membacanya
            session()->flash('detail_struk', $detail_struk);
            session()->flash('total_berat', $total_berat);
            session()->flash('saldo_sebelum', $saldo_lama);
            session()->flash('saldo_sekarang', $saldo_baru);
        });

        // Arahkan ke halaman struk HTML
        return redirect()->route('transaksi.cetak', $id_transaksi_baru)->with('success', 'Transaksi Berhasil Disimpan!');
    }

    public function cetakStruk($id)
    {
        // Mengambil data transaksi gabung dengan nama nasabah + nama petugas
        $transaksi = DB::table('tb_transaksi')
            ->leftJoin('tb_nasabah', 'tb_transaksi.id_nasabah', '=', 'tb_nasabah.id_nasabah')
            ->leftJoin('tb_pengguna', 'tb_transaksi.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select('tb_transaksi.*', 'tb_nasabah.nama as nama_nasabah', 'tb_pengguna.username as nama_petugas')
            ->where('tb_transaksi.id_transaksi', $id)
            ->first();
            
        // Ambil detail rincian dari Session yang dikirim dari fungsi store()
        $detail_struk   = session('detail_struk') ?? [];
        $total_berat    = session('total_berat') ?? 0;
        $saldo_sebelum  = session('saldo_sebelum') ?? 0;
        $saldo_sekarang = session('saldo_sekarang') ?? $transaksi->total_nilai;

        // Tampilkan ke view struk HTML
        return view('petugas.transaksi.struk', compact('transaksi', 'detail_struk', 'total_berat', 'saldo_sebelum', 'saldo_sekarang'));
    }
}