<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // <-- PASTIKAN INI DITAMBAHKAN

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // 1. Validasi Input (Hapus validasi 'nama' agar tidak error)
        $request->validate([
            'username' => 'required|unique:tb_pengguna,username',
            'email'    => 'required|email|unique:tb_pengguna,email',
            'password' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            // 2. Buat profil di tb_nasabah dan AMBIL ID-nya (insertGetId)
            $id_nasabah_baru = DB::table('tb_nasabah')->insertGetId([
                'nama'       => $request->username, // Gunakan username sebagai nama
                'alamat'     => '-',
                'no_hp'      => '-',
                'tgl_daftar' => \Carbon\Carbon::now(),
            ]);

            // 3. Buat akun di tb_pengguna menggunakan ID dari langkah 2
            DB::table('tb_pengguna')->insert([
                'id_nasabah'   => $id_nasabah_baru, 
                'username'     => $request->username,
                'email'        => $request->email,
                'password'     => Hash::make($request->password),
                'peran'        => 'nasabah',
                'status_aktif' => 1,
            ]);

            // 4. Siapkan saldo awal Rp 0 di tb_saldo
            DB::table('tb_saldo')->insert([
                'id_nasabah'     => $id_nasabah_baru,
                'saldo_tersedia' => 0,
                'tgl_update'     => \Carbon\Carbon::now(),
            ]);
        });

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Cek username dan password di database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. Arahkan ke dashboard sesuai peran
            if ($user->peran === 'admin') {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->peran === 'petugas') {
                return redirect()->intended('petugas/dashboard');
            } elseif ($user->peran === 'nasabah') {
                return redirect()->intended('nasabah/dashboard');
            }

            // Jika peran tidak ada yang cocok
            Auth::logout();
            return redirect('/login')->with('error', 'Akses peran tidak dikenali.');
        }

        // Jika salah password / username
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }
}