<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lab_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('instruktur_id');

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('lab_schedules', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};