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
        Schema::create('surahs', function (Blueprint $table) {
            $table->id(); // ID as Surah number (1-114)
            $table->string('nama_latin');
            $table->string('nama_arab');
            $table->integer('jumlah_ayat');
            $table->string('tempat_turun'); // Makkiyah / Madaniyah
            // No timestamps needed since it's a static dictionary table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
