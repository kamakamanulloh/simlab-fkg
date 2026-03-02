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
        if (!Schema::hasTable('pelatihans')) {
            Schema::create('pelatihans', function (Blueprint $table) {
             $table->id();

$table->string('nama_pelatihan');
$table->string('jenis_pelatihan');
$table->string('lokasi');
$table->string('level');
$table->integer('kuota');

// Tambahan sesuai form
$table->string('alat_status')->nullable();
$table->string('bahan_status')->nullable();
$table->string('k3_status')->nullable();
$table->text('materi')->nullable();

$table->string('status_pelaksanaan');
$table->string('hasil');

$table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pelatihans')) {
            Schema::dropIfExists('pelatihans');
        }
    }

};
