<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini mengarah ke tb_pengguna
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Isi data Admin (Tanpa kolom name)
        User::create([
            'username' => 'admin',
            'email' => 'admin@simabas.id',
            'password' => Hash::make('passwordadmin123'),
            'peran' => 'admin',
            'status_aktif' => 1,
        ]);

        // 2. Isi data Petugas (Tanpa kolom name)
        User::create([
            'username' => 'petugas1',
            'email' => 'petugas1@simabas.id',
            'password' => Hash::make('passwordpetugas123'),
            'peran' => 'petugas',
            'status_aktif' => 1,
        ]);
    }
}