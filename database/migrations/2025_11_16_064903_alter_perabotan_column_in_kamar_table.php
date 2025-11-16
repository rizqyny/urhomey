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
        DB::statement('
        ALTER TABLE kamar
        ALTER COLUMN perabotan TYPE json
        USING perabotan::json
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('
        ALTER TABLE kamar
        ALTER COLUMN perabotan TYPE varchar(255)
    ');
    }
};
