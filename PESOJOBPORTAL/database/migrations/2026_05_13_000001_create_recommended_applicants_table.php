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
        Schema::create('recommended_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('peso_job_id')->constrained('peso_jobs')->onDelete('cascade');
            $table->foreignId('recommended_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recommended_to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('recommendation_reason')->nullable();
            $table->enum('recommendation_type', ['employer_to_employer', 'employer_to_peso', 'peso_to_employer', 'general'])->default('general');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'hired'])->default('pending');
            
            // Response tracking
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->text('response_notes')->nullable();
            
            // Follow-up tracking
            $table->integer('followup_count')->default(0);
            $table->timestamp('first_followup_at')->nullable();
            $table->timestamp('last_followup_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('last_email_sent_at')->nullable();
            
            // For tracking if recommendation was acted upon
            $table->boolean('is_reviewed')->default(false);
            $table->boolean('is_shared')->default(false);
            
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['job_application_id', 'status']);
            $table->index(['recommended_by_user_id', 'created_at']);
            $table->index(['recommended_to_user_id', 'status']);
            $table->index(['peso_job_id', 'status']);
            $table->index(['viewed_at', 'status']);
            $table->index(['responded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommended_applicants');
    }
};
