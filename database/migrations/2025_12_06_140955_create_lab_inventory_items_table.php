<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_inventory_items', function (Blueprint $table) {
            $table->id();

            $table->enum('item_type', ['peralatan', 'bahan']); // peralatan / bahan habis pakai

            $table->string('code')->unique();   // EQ-001 / SP-001
            $table->string('name');

            $table->string('category')->nullable();

            // --- KHUSUS PERALATAN ---
            $table->string('location')->nullable();       // Lab 1, Lab 2, dst
            $table->string('status')->nullable();         // Aktif / Kalibrasi / Perbaikan / Nonaktif
            $table->date('last_calibration_date')->nullable();
            $table->date('next_calibration_date')->nullable();

            // --- KHUSUS BAHAN HABIS PAKAI ---
            $table->string('unit')->nullable();           // box, syringe, pack, dll
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('min_stock')->default(0);
            $table->string('batch_lot')->nullable();
            $table->date('expired_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_inventory_items');
    }
};
