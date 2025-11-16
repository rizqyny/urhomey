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
        Schema::create('kamar', function (Blueprint $table) {
            $table->string('nomor_kamar')->primary();
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_penyewa')->nullable();
            $table->foreign('id_penyewa')
                    ->references('id_penyewa')
                    ->on('penyewa')
                    ->onDelete('set null');
            $table->string('perabotan');
            $table->string('lokasi_lantai');
            $table->string('status_kamar');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
