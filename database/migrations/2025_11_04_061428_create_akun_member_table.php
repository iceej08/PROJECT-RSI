<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun_membership', function (Blueprint $table) {
            $table->id('id_membership');
            $table->foreignId('id_akun')->constrained('akun_ubsc', 'id_akun')->onDelete('cascade');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_berakhir');
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun_membership');
    }
};
