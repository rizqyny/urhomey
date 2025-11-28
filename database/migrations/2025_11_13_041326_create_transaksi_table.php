<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi'); // SERIAL

            // FK ke kamar.nomor_kamar
            $table->string('nomor_kamar');
            $table->foreign('nomor_kamar')
                  ->references('nomor_kamar')
                  ->on('kamar')
                  ->onDelete('cascade');

            // FK ke metode_pembayaran.id_metode
            $table->unsignedBigInteger('id_metode');
            $table->foreign('id_metode')
                  ->references('id_metode')
                  ->on('metode_pembayaran')
                  ->onDelete('restrict');

            $table->date('tanggal_transaksi');
            $table->integer('nominal');
            $table->string('status')->default('menunggu'); // pending, sukses, gagal

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
