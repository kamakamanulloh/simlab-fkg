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
           if (!Schema::hasTable('insidens')) {
       
         Schema::create('insidens', function (Blueprint $table) {
        $table->id();

        // A. Identitas
        $table->string('id_insiden');
        $table->datetime('tgl_kejadian');
        $table->date('tgl_pelaporan');
        $table->string('unit');
        $table->string('lokasi');
        $table->string('jenis_insiden');

        // B. Pelapor
        $table->string('nama_pelapor');
        $table->string('jabatan');
        $table->string('kontak')->nullable();
        $table->string('status_pelapor')->nullable();

        // C. Detail
        $table->string('judul')->nullable();
        $table->text('deskripsi');
        $table->string('jenis_dampak');
        $table->string('tingkat_keparahan');
        $table->string('kategori_ncr');

        // F. Bukti
        $table->json('dokumen_pendukung')->nullable();

        $table->timestamps();
    });
           }
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insidens');
    }
};
