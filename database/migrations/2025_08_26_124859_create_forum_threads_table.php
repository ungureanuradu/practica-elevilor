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
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->enum('status', ['active', 'locked', 'pinned', 'archived'])->default('active');
            $table->enum('type', ['discussion', 'question', 'announcement', 'sticky'])->default('discussion');
            $table->boolean('is_solved')->default(false); // For question threads
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->json('tags')->nullable();
            $table->foreignId('category_id')->constrained('forum_categories')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('last_post_id')->nullable()->constrained('forum_posts')->nullOnDelete();
            $table->foreignId('solved_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_reply_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_threads');
    }
};
