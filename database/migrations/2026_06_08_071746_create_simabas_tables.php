<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Nasabah
        Schema::create('tb_nasabah', function (Blueprint $table) {
            $table->id('id_nasabah');
            $table->string('nama', 150);
            $table->text('alamat');
            $table->string('no_hp', 15);
            $table->string('email', 100)->nullable();
            $table->date('tgl_daftar');
            $table->boolean('status_aktif')->default(1);
            $table->timestamps();
        });

        // 2. Tabel Pengguna
        Schema::create('tb_pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->foreignId('id_nasabah')->nullable()->constrained('tb_nasabah', 'id_nasabah')->onDelete('cascade');
            $table->string('username', 100)->unique();
            $table->string('email', 100)->nullable();
            $table->string('password', 255);
            $table->enum('peran', ['admin', 'petugas', 'nasabah']);
            $table->boolean('status_aktif')->default(1);
            $table->timestamps();
        });

        // 3. Tabel Jenis Sampah
        Schema::create('tb_jenis_sampah', function (Blueprint $table) {
            $table->id('id_jenis'); 
            $table->string('kategori', 100); // Sekarang kategori yang menyimpan Plastik, Kertas, dll
            $table->integer('harga_per_kg'); 
            $table->integer('status_aktif')->default(1); 
            $table->timestamps(); 
        });

        // 4. Tabel Transaksi
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_nasabah')->constrained('tb_nasabah', 'id_nasabah');
            $table->foreignId('id_pengguna')->constrained('tb_pengguna', 'id_pengguna');
            $table->dateTime('tgl_transaksi');
            $table->enum('tipe_transaksi', ['setoran', 'penarikan']);
            $table->decimal('total_nilai', 12, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Detail Transaksi
        Schema::create('tb_detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_transaksi')->constrained('tb_transaksi', 'id_transaksi')->onDelete('cascade');
            $table->foreignId('id_jenis')->constrained('tb_jenis_sampah', 'id_jenis');
            $table->decimal('berat_kg', 8, 2);
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        // 6. Tabel Saldo
        Schema::create('tb_saldo', function (Blueprint $table) {
            $table->id('id_saldo');
            $table->foreignId('id_nasabah')->unique()->constrained('tb_nasabah', 'id_nasabah')->onDelete('cascade');
            $table->decimal('saldo_tersedia', 14, 2)->default(0.00);
            $table->dateTime('tgl_update');
            $table->timestamps();
        });

        // 7. Tabel Log Aktivitas
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_pengguna')->constrained('tb_pengguna', 'id_pengguna');
            $table->string('aktivitas', 255);
            $table->timestamp('waktu')->useCurrent(); // Tambahkan ->useCurrent()
            $table->string('ip_address', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
        Schema::dropIfExists('tb_saldo');
        Schema::dropIfExists('tb_detail_transaksi');
        Schema::dropIfExists('tb_transaksi');
        Schema::dropIfExists('tb_jenis_sampah');
        Schema::dropIfExists('tb_pengguna');
        Schema::dropIfExists('tb_nasabah');
    }
};