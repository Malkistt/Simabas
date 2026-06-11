<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;


protected $table = 'tb_nasabah'; // <--- Tambahkan ini
protected $primaryKey = 'id_nasabah'; // Sesuaikan dengan PK di DB Anda   
// Menentukan kolom apa saja yang boleh diisi (Mass Assignment)
protected $fillable = ['nama', 'alamat', 'no_hp', 'email', 'tgl_daftar', 'status_aktif'];
    // Menghubungkan Nasabah ke User (Setiap Nasabah punya 1 User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}