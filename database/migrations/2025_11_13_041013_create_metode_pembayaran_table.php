<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id('id_metode'); // SERIAL / AUTO INCREMENT
            $table->string('nama_metode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
