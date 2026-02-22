<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenances')) {
        Schema::create('k3_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('kode_insiden')->unique(); // INC-001
            $table->string('judul');
            $table->date('tanggal_kejadian');
            $table->enum('tingkat_keparahan', ['Ringan', 'Sedang', 'Berat']);
            $table->string('pelapor');
            $table->string('lokasi')->nullable();
            $table->string('capa_ref')->nullable(); // Referensi CAPA-001
            $table->enum('status', ['Baru', 'Investigasi', 'Selesai']);
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('k3_incidents');
    }
};