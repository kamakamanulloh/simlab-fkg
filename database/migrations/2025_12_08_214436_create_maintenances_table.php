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
        if (!Schema::hasTable('maintenances')) {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke item inventori (peralatan)
            $table->foreignId('inventory_id')->constrained('lab_inventory_items')->onDelete('cascade'); 
            
            // Detail Kegiatan
            $table->string('judul'); // Autoclave - Pemeliharaan Preventif
            $table->enum('jenis', ['Preventive', 'Corrective', 'Calibration']);
            $table->string('teknisi'); // Nama teknisi atau Vendor
            $table->decimal('biaya', 10, 2)->default(0);
            $table->longText('deskripsi')->nullable();
            
            // Jadwal dan Status
            $table->date('tanggal_jadwal');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['Terjadwal', 'Berlangsung', 'Selesai', 'Terlambat']);
            
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};