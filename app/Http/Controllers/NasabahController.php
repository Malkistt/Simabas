<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
            {
                // Mengambil data nasabah dari database
                $daftar_nasabah = DB::table('tb_nasabah')
                    ->leftJoin('tb_pengguna', 'tb_nasabah.id_nasabah', '=', 'tb_pengguna.id_nasabah')
                    ->leftJoin('tb_saldo', 'tb_nasabah.id_nasabah', '=', 'tb_saldo.id_nasabah')
                    ->select(
                        'tb_nasabah.*', 
                        'tb_pengguna.email', 
                        'tb_pengguna.username',
                        'tb_pengguna.status_aktif',
                        'tb_saldo.saldo_tersedia'
                    )
                    ->orderBy('tb_nasabah.tgl_daftar', 'desc')
                    ->paginate(5);

                // PENGALIHAN VIEW BERDASARKAN PERAN (ROLE)
                if (auth()->user()->peran === 'admin') {
                    return view('admin.nasabah.index', compact('daftar_nasabah'));
                } else {
                    return view('petugas.nasabah.index', compact('daftar_nasabah'));
                }
            }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nasabah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            
            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
                'role' => 'nasabah', 
                'status' => 'aktif',
            ]);

            Nasabah::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'saldo' => 0, 
                'status' => 'aktif',
            ]);

        });

        return redirect()->route('nasabah.index')->with('success', 'Nasabah baru berhasil didaftarkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
/**
     * Menampilkan halaman form edit.
     */
    public function edit(string $id)
    {
        // Ambil data gabungan dari tb_nasabah dan tb_pengguna berdasarkan id_nasabah
        $nasabah = DB::table('tb_nasabah')
            ->leftJoin('tb_pengguna', 'tb_nasabah.id_nasabah', '=', 'tb_pengguna.id_nasabah')
            ->where('tb_nasabah.id_nasabah', $id)
            ->first();

        return view('nasabah.edit', compact('nasabah'));
    }

    /**
     * Menyimpan perubahan data edit.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            // 1. Update data akun login di tb_pengguna
            DB::table('tb_pengguna')->where('id_nasabah', $id)->update([
                'username' => $request->username,
                'email' => $request->email,
            ]);

            // 2. Update data biodata di tb_nasabah
            DB::table('tb_nasabah')->where('id_nasabah', $id)->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui!');
    }
}
