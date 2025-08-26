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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('type', ['full-time', 'part-time', 'internship', 'mentorship', 'freelance'])->default('full-time');
            $table->enum('level', ['entry', 'junior', 'mid', 'senior'])->default('entry');
            $table->enum('status', ['active', 'paused', 'closed'])->default('active');
            $table->string('location')->nullable();
            $table->boolean('remote_ok')->default(false);
            $table->boolean('hybrid_ok')->default(false);
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 3)->default('RON');
            $table->boolean('salary_negotiable')->default(true);
            $table->json('skills_required')->nullable();
            $table->json('skills_preferred')->nullable();
            $table->integer('positions_available')->default(1);
            $table->date('application_deadline')->nullable();
            $table->date('start_date')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('application_url')->nullable();
            $table->boolean('cv_required')->default(true);
            $table->boolean('cover_letter_required')->default(false);
            $table->text('application_instructions')->nullable();
            $table->foreignId('company_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
