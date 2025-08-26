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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('excerpt')->nullable();
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('duration_hours')->default(0);
            $table->integer('max_students')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->boolean('is_free')->default(true);
            $table->json('tags')->nullable();
            $table->json('requirements')->nullable();
            $table->json('learning_outcomes')->nullable();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
