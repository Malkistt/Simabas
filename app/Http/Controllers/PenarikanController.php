<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PenarikanController extends Controller
{
    public function create()
    {
        // Jika nasabah yang membuka halaman, arahkan ke form penarikan langsung sisi nasabah
        if (Auth::user()->peran === 'nasabah' || request()->is('*nasabah*')) {
            $total_saldo = DB::table('tb_saldo')->where('id_nasabah', Auth::user()->id_nasabah)->value('saldo_tersedia') ?? 0;
            return view('nasabah.pengajuan', compact('total_saldo'));
        }

        // Jika petugas yang membuka, ambil daftar nasabah untuk dropdown pencarian
        $nasabah = DB::table('tb_nasabah')
            ->leftJoin('tb_saldo', 'tb_nasabah.id_nasabah', '=', 'tb_saldo.id_nasabah')
            ->select('tb_nasabah.id_nasabah', 'tb_nasabah.nama', 'tb_saldo.saldo_tersedia')
            ->get();

        return view('petugas.penarikan.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        // 1. Validasi nominal penarikan dasar
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
        ]);

        // 2. Tentukan ID Nasabah berdasarkan siapa yang login / mengirim form
        // Jika nasabah yang akses, pakai ID nasabah dari akun loginnya sendiri
        if (Auth::user()->peran === 'nasabah') {
            $id_nasabah = Auth::user()->id_nasabah;
        } else {
            // Jika petugas, ambil dari dropdown nasabah_id yang dipilih di form
            $request->validate(['nasabah_id' => 'required']);
            $id_nasabah = $request->nasabah_id;
        }

        // 3. Ambil data saldo mutakhir dari tb_saldo berdasarkan ID Nasabah
        $saldo_saat_ini = DB::table('tb_saldo')
            ->where('id_nasabah', $id_nasabah)
            ->value('saldo_tersedia') ?? 0;

        // 4. Validasi kecukupan nominal saldo
        if ($saldo_saat_ini < $request->nominal) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal! Saldo tidak mencukupi untuk melakukan transaksi penarikan.');
        }

        // 5. Eksekusi transaksi database secara aman (Saldo langsung berkurang)
        DB::transaction(function () use ($request, $id_nasabah, $saldo_saat_ini) {
            $waktu_sekarang = Carbon::now();
            
            // Catat ID Petugas jika yang memproses adalah petugas, kosongkan jika ditarik mandiri oleh nasabah
            $id_petugas_aktif = Auth::user()->peran === 'petugas' ? Auth::id() : null;

            // A. Masukkan data log transaksi ke tb_transaksi
            DB::table('tb_transaksi')->insert([
                'id_nasabah'     => $id_nasabah,
                'id_pengguna'    => Auth::id(),
                'tgl_transaksi'  => $waktu_sekarang,
                'tipe_transaksi' => 'penarikan',
                'total_nilai'    => $request->nominal,
                'keterangan'     => $request->keterangan ?? 'Penarikan Uang Tunai Saldo',
                'created_at'     => $waktu_sekarang,
                'updated_at'     => $waktu_sekarang,
            ]);

            // B. POTONG SALDO LANGSUNG DI DATABASE (`tb_saldo`)
            DB::table('tb_saldo')
                ->where('id_nasabah', $id_nasabah)
                ->update([
                    'saldo_tersedia' => $saldo_saat_ini - $request->nominal,
                    'updated_at'     => $waktu_sekarang
                ]);
        });

        // 6. Redirect sukses berdasarkan peran pengguna
        if (Auth::user()->peran === 'nasabah') {
            return redirect()->back()->with('success', 'Penarikan saldo berhasil! Uang Anda telah dicairkan dan saldo langsung terpotong.');
        }

        return redirect()->route('riwayat.index')->with('success', 'Penarikan saldo nasabah berhasil dicatat dan saldo otomatis dipotong!');
    }
}