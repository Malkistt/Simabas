<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenarikan extends Model
{
    use HasFactory;

    // Beri tahu Laravel nama tabel aslinya
    protected $table = 'tb_transaksi';
    // Kolom yang boleh diisi
    protected $fillable = [
        'nasabah_id',
        'petugas_id',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    // Relasi balik ke Nasabah
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    // Relasi balik ke Petugas (User)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}