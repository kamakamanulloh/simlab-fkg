<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenances')) {
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->string('task'); // Nama tugas
            $table->enum('status', ['ok', 'warning'])->default('ok'); // Status
            $table->date('tanggal_cek');
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};