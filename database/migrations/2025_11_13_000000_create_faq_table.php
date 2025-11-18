<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('Id_FAQ');
            $table->integer('Id_admin');
            $table->text('Pertanyaan');
            $table->text('Jawaban');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
