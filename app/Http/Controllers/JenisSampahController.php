<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        return view('admin.jenis_sampah.index');
    }

    public function create()
    {
        return view('admin.jenis_sampah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama_jenis' => 'required',
        'kategori' => 'required',
        'harga_per_kg' => 'required|numeric',
        ]);

        JenisSampah::create([
        'nama_jenis' => $request->nama_jenis,
        'kategori' => $request->kategori,
        'harga_per_kg' => $request->harga_per_kg,
        ]);

        return redirect('admin/jenis-sampah')->with('success', 'Data berhasil ditambahkan!');
    }
}