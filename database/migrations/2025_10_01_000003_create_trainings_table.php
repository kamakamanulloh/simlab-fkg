<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenances')) {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('vendor');
            $table->string('durasi'); // e.g. "4 jam"
            $table->date('tanggal');
            $table->integer('peserta_terdaftar');
            $table->integer('peserta_maks');
            $table->json('topik'); // Menyimpan array topik: ["Hazard", "PPE"]
            $table->enum('status', ['Terjadwal', 'Selesai', 'Batal']);
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};