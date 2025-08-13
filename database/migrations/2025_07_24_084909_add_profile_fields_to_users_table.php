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
        Schema::table('users', function (Blueprint $table) {
            // Tip utilizator
            $table->enum('role', ['student', 'teacher', 'company'])->default('student')->after('email');
            
            // Informații de profil comune
            $table->text('bio')->nullable()->after('role');
            $table->string('phone')->nullable()->after('bio');
            $table->string('location')->nullable()->after('phone');
            $table->string('website')->nullable()->after('location');
            
            // Pentru studenți
            $table->string('school')->nullable()->after('website');
            $table->string('year_of_study')->nullable()->after('school');
            $table->json('skills')->nullable()->after('year_of_study');
            $table->string('cv_path')->nullable()->after('skills');
            
            // Pentru profesori
            $table->string('department')->nullable()->after('cv_path');
            $table->string('title')->nullable()->after('department');
            $table->json('specializations')->nullable()->after('title');
            
            // Pentru companii
            $table->string('company_name')->nullable()->after('specializations');
            $table->string('company_type')->nullable()->after('company_name');
            $table->integer('company_size')->nullable()->after('company_type');
            $table->text('company_description')->nullable()->after('company_size');
            
            // Setări
            $table->boolean('is_public')->default(true)->after('company_description');
            $table->boolean('is_available_for_contact')->default(true)->after('is_public');
            $table->timestamp('profile_completed_at')->nullable()->after('is_available_for_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'bio', 'phone', 'location', 'website',
                'school', 'year_of_study', 'skills', 'cv_path',
                'department', 'title', 'specializations',
                'company_name', 'company_type', 'company_size', 'company_description',
                'is_public', 'is_available_for_contact', 'profile_completed_at'
            ]);
        });
    }
};