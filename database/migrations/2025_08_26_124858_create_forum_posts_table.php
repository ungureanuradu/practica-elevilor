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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('status', ['active', 'hidden', 'deleted'])->default('active');
            $table->boolean('is_solution')->default(false); // For marking best answers
            $table->boolean('is_edited')->default(false);
            $table->integer('likes_count')->default(0);
            $table->json('attachments')->nullable(); // For file attachments
            $table->unsignedBigInteger('thread_id');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('forum_posts')->cascadeOnDelete(); // For nested replies
            $table->foreignId('edited_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
