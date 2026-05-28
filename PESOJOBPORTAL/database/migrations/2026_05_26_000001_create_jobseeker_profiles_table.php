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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_initial')->nullable();
            $table->string('suffix')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('religion')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('height')->nullable();
            $table->string('tin')->nullable();
            $table->string('email_address')->nullable();
            $table->string('gender')->nullable();
            
            // Address Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            
            // Professional Information
            $table->string('skills')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->text('education')->nullable();
            $table->json('training')->nullable();
            $table->json('work_experience')->nullable();
            
            // Employment & Preferences
            $table->json('employment_status')->nullable();
            $table->json('job_preference')->nullable();
            
            // Additional Information
            $table->json('disability')->nullable();
            $table->string('avatar_path')->nullable();
            $table->text('certifications')->nullable();
            $table->json('languages')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_profiles');
    }
};
