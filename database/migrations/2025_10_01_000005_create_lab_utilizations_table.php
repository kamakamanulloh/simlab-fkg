<?php
// database/migrations/2025_10_01_000005_create_lab_utilizations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenances')) {
        Schema::create('lab_utilizations', function (Blueprint $table) {
            $table->id();
            $table->string('lab_name'); // Lab 1, Lab 2, dll
            $table->integer('total_slots'); // Kapasitas slot total
            $table->integer('used_slots'); // Slot terpakai
            $table->float('hours_per_week'); // Jam pemakaian
            $table->date('report_date'); // Tanggal laporan
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_utilizations');
    }
};