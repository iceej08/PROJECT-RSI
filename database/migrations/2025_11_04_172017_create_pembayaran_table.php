<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_invoice')->constrained('invoice', 'id_invoice')->onDelete('cascade');
            $table->foreignId('id_membership')->constrained('akun_membership', 'id_membership')->onDelete('cascade');
            $table->decimal('total_pembayaran', 10, 2);
            $table->enum('metode', ['transfer_bank', 'qris', 'kartu_kredit', 'cash']);
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->enum('status_pembayaran', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('jenis_paket', ['bulanan', 'harian']);
            $table->dateTime('tgl_pembayaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
