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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('type', ['public', 'private', 'secret'])->default('public');
            $table->enum('category', ['academic', 'hobby', 'professional', 'social', 'study', 'project', 'other'])->default('other');
            $table->json('tags')->nullable();
            $table->json('settings')->nullable(); // For group-specific settings
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_approval')->default(false);
            $table->integer('max_members')->nullable(); // null = unlimited
            $table->integer('members_count')->default(0);
            $table->integer('topics_count')->default(0);
            $table->integer('posts_count')->default(0);
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('moderator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
