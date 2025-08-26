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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->enum('type', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'zip', 'rar', 'image', 'video', 'audio', 'other'])->default('other');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('access_level', ['public', 'students', 'teachers', 'authenticated'])->default('public');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_downloadable')->default(true);
            $table->boolean('requires_approval')->default(false);
            $table->integer('downloads_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('file_size')->nullable(); // in bytes
            $table->string('file_extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable(); // For additional file info
            $table->foreignId('category_id')->constrained('document_categories')->cascadeOnDelete();
            $table->foreignId('uploader_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
