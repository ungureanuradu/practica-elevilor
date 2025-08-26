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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('location')->nullable();
            $table->string('url')->nullable(); // For online events
            $table->enum('type', ['single', 'recurring', 'all-day'])->default('single');
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->enum('access_level', ['public', 'students', 'teachers', 'authenticated'])->default('public');
            $table->boolean('is_featured')->default(false);
            $table->boolean('requires_registration')->default(false);
            $table->integer('max_participants')->nullable();
            $table->integer('registered_participants')->default(0);
            $table->json('recurrence_rules')->nullable(); // For recurring events
            $table->json('reminders')->nullable(); // For event reminders
            $table->json('attachments')->nullable(); // For event attachments
            $table->json('metadata')->nullable(); // For additional event data
            $table->foreignId('category_id')->constrained('calendar_categories')->cascadeOnDelete();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('timezone')->default('Europe/Bucharest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
