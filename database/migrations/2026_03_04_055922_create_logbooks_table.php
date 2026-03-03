<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            $table->string('session_name'); // Endodontik - Sesi 1
            $table->string('session_code')->nullable(); // LB-045
            $table->date('session_date');

            $table->text('activity');
            $table->json('competencies')->nullable();

            $table->string('documentation')->nullable();

            $table->enum('status', ['Draft','Submitted','Reviewed'])
                  ->default('Draft');

            $table->integer('score')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};