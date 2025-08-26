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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['owner', 'moderator', 'member', 'invited', 'pending'])->default('member');
            $table->enum('status', ['active', 'inactive', 'banned', 'left'])->default('active');
            $table->text('notes')->nullable(); // For moderator notes
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            // Ensure one membership per user per group
            $table->unique(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
