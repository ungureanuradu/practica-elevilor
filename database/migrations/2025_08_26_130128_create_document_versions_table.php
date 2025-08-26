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
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version_number');
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size'); // in bytes
            $table->string('file_extension');
            $table->string('mime_type');
            $table->text('change_notes')->nullable();
            $table->json('metadata')->nullable();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploader_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};
