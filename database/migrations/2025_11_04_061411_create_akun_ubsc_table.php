<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun_ubsc', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->boolean('kategori')->default(false);
            $table->string('foto_identitas', 255)->nullable();
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('tgl_daftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun_ubsc');
    }
};
