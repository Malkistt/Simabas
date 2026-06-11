<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Jangan lupa tambahkan Hash

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Ambil data gabungan dari tb_nasabah dan tb_pengguna
        $nasabah = DB::table('tb_nasabah')
            ->join('tb_pengguna', 'tb_nasabah.id_nasabah', '=', 'tb_pengguna.id_nasabah')
            ->where('tb_nasabah.id_nasabah', $user->id_nasabah)
            ->select('tb_nasabah.*', 'tb_pengguna.email', 'tb_pengguna.username', 'tb_pengguna.created_at as tanggal_akun')
            ->first();

        if (!$nasabah) {
            $nasabah = (object) [
                'id_nasabah' => $user->id_nasabah,
                'nama'       => $user->username ?? 'Nasabah Baru',
                'no_hp'      => '-',
                'email'      => $user->email ?? '-',
                'username'   => $user->username ?? '-',
                'alamat'     => '-',
                'created_at' => $user->created_at ?? now()
            ];
        } else {
            if (empty($nasabah->created_at)) {
                $nasabah->created_at = $nasabah->tanggal_akun ?? now();
            }
        }

        return view('profil.profil', compact('nasabah'));
    }

    // FUNGSI BARU UNTUK MENYIMPAN DATA DARI POPUP
    public function update(Request $request)
    {
        $id_nasabah = Auth::user()->id_nasabah;

        // 1. Validasi Input
        $request->validate([
            'nama'   => 'nullable|string|max:255',
            'no_hp'  => 'nullable|string',
            'alamat' => 'nullable|string',
            'password_baru' => 'nullable|string|confirmed',
        ]);

        try {
            DB::transaction(function () use ($request, $id_nasabah) {
                
                // Jika form "Edit Data Diri" dikirim
                if ($request->filled('nama')) {
                    // Update tb_nasabah
                    DB::table('tb_nasabah')
                        ->where('id_nasabah', $id_nasabah)
                        ->update([
                            'nama'       => $request->nama,
                            'no_hp'      => $request->no_hp,
                            'alamat'     => $request->alamat,
                            'updated_at' => now(),
                        ]);
                }

                // Jika form "Ubah Password" dikirim
                if ($request->filled('password_baru')) {
                    DB::table('tb_pengguna')
                        ->where('id_nasabah', $id_nasabah)
                        ->update([
                            'password'   => Hash::make($request->password_baru),
                            'updated_at' => now(),
                        ]);
                }
            });

            return redirect()->back()->with('success', 'Data berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }
}