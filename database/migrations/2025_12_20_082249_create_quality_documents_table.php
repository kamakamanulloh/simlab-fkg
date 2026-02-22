<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('quality_documents')) {
        Schema::create('quality_documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_id')->unique(); // DOC-00X
            $table->string('title');
            $table->string('version');
            $table->string('category')->nullable();
            $table->date('last_update');
            $table->string('status')->default('Current');
            $table->string('file_path'); // Path file yang diupload
            $table->timestamps();
        });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_documents');
    }
};