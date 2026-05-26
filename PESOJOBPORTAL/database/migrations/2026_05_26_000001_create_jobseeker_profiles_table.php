<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            // Personal Information
            $table->json('personal_information')->nullable();
            
            // Address Information
            $table->json('present_address')->nullable();
            $table->json('permanent_address')->nullable();
            
            // Formatted display fields
            $table->string('resume_name')->nullable();
            $table->string('resume_email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Resume/Document Storage
            $table->string('resume_path')->nullable();
            $table->string('photo_path')->nullable();
            
            // Skills and Qualifications (JSON stored)
            $table->json('skills')->nullable();
            $table->json('education')->nullable();
            $table->json('training')->nullable();
            $table->json('experience')->nullable();
            $table->json('eligibility')->nullable();
            $table->json('other_skills')->nullable();
            $table->json('languages')->nullable();
            
            // Employment Information
            $table->json('employment_status')->nullable();
            $table->json('job_preferences')->nullable();
            
            // Accessibility Information
            $table->json('disability')->nullable();
            
            // Profile Metadata
            $table->text('objective')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->integer('completion_percentage')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_profiles');
    }
};
