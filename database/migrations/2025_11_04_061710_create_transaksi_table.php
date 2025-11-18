<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_membership')->constrained('akun_membership', 'id_membership')->onDelete('cascade');
            $table->enum('jenis_paket', ['bulanan', 'harian']);
            $table->dateTime('tgl_transaksi');
            $table->decimal('total_tagihan', 10, 2);
            $table->enum('status_transaksi', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
