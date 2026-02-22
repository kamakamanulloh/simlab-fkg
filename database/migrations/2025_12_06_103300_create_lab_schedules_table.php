<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('judul');                 // Judul kegiatan
            $table->string('jenis')->nullable();     // Praktikum / OSCE / Pelatihan / dll
            $table->string('ruangan')->nullable();   // Nama ruangan
            $table->date('tanggal')->nullable();     // Tanggal kegiatan
            $table->string('waktu')->nullable();     // Contoh: "08:00 - 11:00"
            $table->string('instruktur')->nullable();// Nama instruktur/dosen
            $table->unsignedInteger('jumlah_peserta')->nullable();
            $table->text('catatan')->nullable();     // Catatan / kebutuhan khusus
            $table->string('status')->default('menunggu'); // menunggu / disetujui / ditolak
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_schedules');
    }
};
