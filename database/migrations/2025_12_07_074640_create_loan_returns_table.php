<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_returns', function (Blueprint $table) {
            $table->id();

            // Relasi ke detail peminjaman
            $table->foreignId('loan_item_id')
                  ->constrained('loan_items')
                  ->onDelete('cascade');

            // Waktu pengembalian
            $table->dateTime('returned_at');

            // Kondisi alat saat kembali (Baik, Rusak, dll)
            $table->string('condition')->nullable();

            // Catatan tambahan (opsional)
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_returns');
    }
};
