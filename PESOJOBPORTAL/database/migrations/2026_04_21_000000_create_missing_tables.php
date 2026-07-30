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
        // Applicant Feedback Table
        if (!Schema::hasTable('applicant_feedback')) {
            Schema::create('applicant_feedback', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id');
                $table->unsignedBigInteger('employer_id');
                $table->text('feedback');
                $table->integer('rating')->nullable();
                $table->enum('feedback_type', ['interview_experience', 'job_performance', 'professionalism', 'general'])->default('general');
                $table->timestamps();
                
                $table->foreign('application_id')->references('id')->on('job_applications')->onDelete('cascade');
                $table->foreign('employer_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Company Profiles Table
        if (!Schema::hasTable('company_profiles')) {
            Schema::create('company_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('company_name');
                $table->text('description')->nullable();
                $table->string('industry')->nullable();
                $table->string('company_size')->nullable();
                $table->string('website')->nullable();
                $table->string('phone')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('province')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('tin_number')->nullable();
                $table->string('logo_path')->nullable();
                $table->text('about_company')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }

        // Employer Documents Table
        if (!Schema::hasTable('employer_documents')) {
            Schema::create('employer_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('document_type');
                $table->string('file_path');
                $table->string('status')->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }

        // Jobseeker Profiles Table
        if (!Schema::hasTable('jobseeker_profiles')) {
            Schema::create('jobseeker_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->text('bio')->nullable();
                $table->string('phone')->nullable();
                $table->string('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('province')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('skills')->nullable();
                $table->integer('years_of_experience')->nullable();
                $table->text('education')->nullable();
                $table->string('avatar_path')->nullable();
                $table->text('certifications')->nullable();
                $table->text('languages')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }

        // Job Batches Table
        if (!Schema::hasTable('job_batches')) {
            Schema::create('job_batches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->longText('failed_job_ids')->nullable();
                $table->mediumText('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('started_at')->nullable();
                $table->integer('finished_at')->nullable();
            });
        }

        // LRA Requests Table
        if (!Schema::hasTable('lra_requests')) {
            Schema::create('lra_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('lra_code')->nullable();
                $table->string('status')->default('pending');
                $table->dateTime('request_date')->nullable();
                $table->dateTime('approved_date')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }

        // Notifications Table
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('title');
                $table->text('message');
                $table->string('type')->nullable();
                $table->string('action_url')->nullable();
                $table->boolean('is_read')->default(false);
                $table->dateTime('read_at')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index(['user_id', 'is_read']);
            });
        }

        // Password Reset Tokens Table (if not exists)
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        // PESO Clearances Table
        if (!Schema::hasTable('peso_clearances')) {
            Schema::create('peso_clearances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('clearance_number')->unique();
                $table->dateTime('issue_date');
                $table->dateTime('expiry_date')->nullable();
                $table->string('status')->default('active');
                $table->text('remarks')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }

        // Recommended Jobs Table
        if (!Schema::hasTable('recommended_jobs')) {
            Schema::create('recommended_jobs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('job_id');
                $table->decimal('match_score', 5, 2)->nullable();
                $table->string('reason')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('job_id')->references('id')->on('peso_jobs')->onDelete('cascade');
                $table->index(['user_id', 'created_at']);
            });
        }

        // Report Templates Table
        if (!Schema::hasTable('report_templates')) {
            Schema::create('report_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('sql_query')->nullable();
                $table->string('template_type');
                $table->json('fields')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
                
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $table->index('created_by');
            });
        }

        // Saved Jobs Table
        if (!Schema::hasTable('saved_jobs')) {
            Schema::create('saved_jobs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('job_id');
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('job_id')->references('id')->on('peso_jobs')->onDelete('cascade');
                $table->unique(['user_id', 'job_id']);
                $table->index(['user_id', 'created_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
        Schema::dropIfExists('report_templates');
        Schema::dropIfExists('recommended_jobs');
        Schema::dropIfExists('peso_clearances');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('lra_requests');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobseeker_profiles');
        Schema::dropIfExists('employer_documents');
        Schema::dropIfExists('company_profiles');
        Schema::dropIfExists('applicant_feedback');
    }
};
