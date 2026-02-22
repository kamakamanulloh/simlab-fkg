<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenances')) {
        Schema::create('waste_logs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_limbah')->unique(); // WST-001
            $table->string('jenis_limbah'); // B3 - Bahan Kimia
            $table->string('kategori'); // Limbah Cair / Padat
            $table->string('volume'); // 25.5 liter (bisa dipisah value & unit jika perlu)
            $table->date('tanggal');
            $table->string('vendor');
            $table->string('no_manifest')->nullable(); // MNF-2025...
            $table->string('status'); // Terbuang / Diambil
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_logs');
    }
};