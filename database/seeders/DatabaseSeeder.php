<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Memanggil semua seeder yang kita butuhkan
        $this->call([
            PenggunaSeeder::class,    // Seeder untuk Admin & Petugas
            DummyDataSeeder::class,   // Seeder untuk Nasabah & Transaksi
            JenisSampahSeeder::class, // <-- INI YANG KURANG (Seeder Jenis Sampah)
        ]);
    }
}