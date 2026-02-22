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
         if (!Schema::hasTable('lab_wastes')) {
      Schema::create('lab_wastes', function (Blueprint $table) {
    $table->id();
    $table->string('jenis_limbah');
    $table->string('kategori');
    $table->string('lokasi')->nullable();
    $table->string('status')->default('Aktif');
    $table->integer('berat')->nullable();

    $table->string('kondisi_wadah')->nullable();
    $table->string('volume_wadah')->nullable();
    $table->string('apd')->nullable();

    $table->text('keterangan')->nullable();

    $table->string('status_verifikasi')->default('Menunggu');
    $table->string('alur_pembuangan')->nullable();

    $table->timestamps();
});
         }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_wastes');
    }
};
