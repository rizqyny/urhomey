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
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->integer('id_penyewa');
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa')->onDelete('cascade');
            $table->string('nomor_kamar');
            $table->foreign('nomor_kamar')->references('nomor_kamar')->on('kamar')->onDelete('cascade');
            $table->string('deskripsi_kerusakan');
            $table->string('status_laporan')->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};
