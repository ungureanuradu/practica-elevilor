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
        Schema::create('forum_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('bookmarkable'); // For bookmarking threads or posts
            $table->text('notes')->nullable(); // User notes about the bookmark
            $table->timestamps();
            
            // Ensure one bookmark per user per item
            $table->unique(['user_id', 'bookmarkable_type', 'bookmarkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_bookmarks');
    }
};
