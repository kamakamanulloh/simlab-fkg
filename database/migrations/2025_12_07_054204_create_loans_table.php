<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->string('loan_code')->unique(); // LN-001

            // Info peminjam (tidak semua peminjam user Laravel)
            $table->string('borrower_name');
          
            $table->string('borrower_nip')->nullable();
          
            $table->string('purpose')->nullable(); // Tujuan: praktikum, workshop

            $table->dateTime('start_at'); // Waktu pinjam
            $table->dateTime('due_at');   // Batas kembali
            $table->dateTime('returned_at')->nullable();

            $table->enum('status', [
                'Dipinjam',
                'Terlambat',
                'Dikembalikan'
            ])->default('Dipinjam');
  $table->string('condition_photo_path')->nullable();
  $table->string('qr_result')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
