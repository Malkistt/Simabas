<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisSampahSeeder extends Seeder
{
    public function run(): void
    {
        $waktu_sekarang = Carbon::now();

        // Data dimasukkan menggunakan kolom 'kategori'
        DB::table('tb_jenis_sampah')->insert([
            [
                'kategori'     => 'Plastik',
                'harga_per_kg' => 2000,
                'status_aktif' => 1,
                'created_at'   => $waktu_sekarang,
                'updated_at'   => $waktu_sekarang,
            ],
            [
                'kategori'     => 'Kertas',
                'harga_per_kg' => 1500,
                'status_aktif' => 1,
                'created_at'   => $waktu_sekarang,
                'updated_at'   => $waktu_sekarang,
            ],
            [
                'kategori'     => 'Kaca',
                'harga_per_kg' => 1000,
                'status_aktif' => 1,
                'created_at'   => $waktu_sekarang,
                'updated_at'   => $waktu_sekarang,
            ],
            [
                'kategori'     => 'Logam',
                'harga_per_kg' => 5000,
                'status_aktif' => 1,
                'created_at'   => $waktu_sekarang,
                'updated_at'   => $waktu_sekarang,
            ],
        ]);
    }
}