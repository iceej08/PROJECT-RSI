<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promosi', function (Blueprint $table) {
            $table->id('Id_promosi');
            $table->integer('Id_admin');
            $table->string('Judul');
            $table->text('Deskripsi');
            $table->string('Gambar')->nullable();
            $table->dateTime('Tgl_mulai');
            $table->dateTime('Tgl_berakhir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promosi');
    }
};
