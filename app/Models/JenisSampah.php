<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    // Field yang boleh diisi melalui form
    protected $fillable = [
        'nama_jenis',
        'kategori',
        'harga_per_kg',
        'status',
    ];
}