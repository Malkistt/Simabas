<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HargaSampahController extends Controller
{
    public function index()
{
    $harga_sampah = DB::table('tb_jenis_sampah')->get();

    return view('admin.harga_sampah', compact('harga_sampah'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'harga_per_kg' => 'required|numeric|min:0'
    ]);

    DB::table('tb_jenis_sampah')
        ->where('id_jenis', $id)
        ->update([
            'harga_per_kg' => $request->harga_per_kg,
            'updated_at' => now()
        ]);

    return redirect()->back()->with(
        'success',
        'Harga sampah berhasil diperbarui!'
    );
}
}