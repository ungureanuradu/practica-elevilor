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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'interviewed', 'accepted', 'rejected'])->default('pending');
            $table->text('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->json('answers')->nullable(); // For custom questions
            $table->text('notes')->nullable(); // For company notes
            $table->text('feedback')->nullable(); // For applicant feedback
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('interview_scheduled_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Ensure one application per job per applicant
            $table->unique(['job_id', 'applicant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
