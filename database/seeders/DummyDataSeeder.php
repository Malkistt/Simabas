<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan format nama/alamat Indonesia

        // ==========================================
        // 2. BUAT 10 NASABAH & TRANSAKSINYA
        // ==========================================
        for ($i = 1; $i <= 10; $i++) {
            
            // A. Buat Biodata Nasabah
            $id_nasabah = DB::table('tb_nasabah')->insertGetId([
                'nama'       => $faker->name,
                'alamat'     => $faker->address,
                'no_hp'      => $faker->numerify('08##########'),
                'tgl_daftar' => Carbon::now()->subDays(rand(1, 30)), // Daftar 1-30 hari yang lalu
            ]);

            // B. Buat Akun Login Nasabah
            DB::table('tb_pengguna')->insert([
                'id_nasabah'   => $id_nasabah,
                'username'     => 'nasabah' . $i,
                'email'        => $faker->unique()->safeEmail,
                'password'     => Hash::make('password123'),
                'peran'        => 'nasabah',
                'status_aktif' => 1,
            ]);

            $total_saldo = 0;

            // C. Buat 2-4 Transaksi Setoran per Nasabah
            $jumlah_setoran = rand(2, 4);
            for ($j = 0; $j < $jumlah_setoran; $j++) {
                $nominal = rand(5, 50) * 1000;
                $total_saldo += $nominal;

                DB::table('tb_transaksi')->insert([
                    'id_nasabah'     => $id_nasabah,
                    'id_pengguna'    => 2, // <--- TAMBAHKAN BARIS INI (2 adalah ID Petugas)
                    'tgl_transaksi'  => Carbon::now()->subDays(rand(1, 15)),
                    'tipe_transaksi' => 'setoran',
                    'total_nilai'    => $nominal,
                    'keterangan'     => 'Setoran rutin via Petugas',
                ]);
            }

            // D. Buat 1 Transaksi Penarikan per Nasabah (Opsional/Acak)
            if (rand(0, 1) == 1 && $total_saldo > 20000) {
                $tarik = rand(1, 2) * 10000; 
                $total_saldo -= $tarik;

                DB::table('tb_transaksi')->insert([
                    'id_nasabah'     => $id_nasabah,
                    'id_pengguna'    => 2, // <--- TAMBAHKAN BARIS INI JUGA
                    'tgl_transaksi'  => Carbon::now()->subDays(rand(1, 5)),
                    'tipe_transaksi' => 'penarikan',
                    'total_nilai'    => $tarik,
                    'keterangan'     => 'Penarikan tunai',
                ]);
            }

            // E. Simpan Saldo Akhir Nasabah    
            DB::table('tb_saldo')->insert([
                'id_nasabah'     => $id_nasabah,
                'saldo_tersedia' => $total_saldo,
                'tgl_update'     => Carbon::now(), // <--- TAMBAHKAN BARIS INI
            ]);
        }
    }
}