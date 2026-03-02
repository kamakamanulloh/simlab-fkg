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
          if (!Schema::hasTable('cost_analyses')) {
       Schema::create('cost_analyses', function (Blueprint $table) {
   $table->id();
$table->string('jenis_tindakan'); // Preventif/Korektif
$table->text('detail_perbaikan');
$table->decimal('biaya', 15, 2);
$table->enum('status_pengerjaan', ['Tepat Waktu', 'Terlambat']);
$table->timestamps();
});
          }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_analyses');
    }
};
