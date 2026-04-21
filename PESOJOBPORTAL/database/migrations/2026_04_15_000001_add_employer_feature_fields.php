<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_employer_verified')->default(false)->after('role');
        });

        Schema::table('peso_jobs', function (Blueprint $table) {
            $table->foreignId('employer_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('position')->nullable()->after('title');
            $table->text('qualifications')->nullable()->after('description');
            $table->string('salary')->nullable()->after('salary_range');
            $table->string('job_type')->nullable()->after('location');
            $table->unsignedInteger('vacancies')->default(1)->after('job_type');
            $table->date('application_start_date')->nullable()->after('vacancies');
            $table->date('application_end_date')->nullable()->after('application_start_date');
            $table->timestamp('archived_at')->nullable()->after('status');
            $table->boolean('is_filled')->default(false)->after('archived_at');
            $table->timestamp('filled_at')->nullable()->after('is_filled');
            $table->foreignId('source_job_id')->nullable()->after('filled_at')->constrained('peso_jobs')->nullOnDelete();
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->boolean('is_referred')->default(false)->after('peso_job_id');
            $table->enum('employer_status', ['interview_scheduled', 'hired', 'not_selected'])->nullable()->after('status');
            $table->enum('final_decision', ['pending', 'hired', 'not_selected'])->default('pending')->after('employer_status');
            $table->text('employer_feedback')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['is_referred', 'employer_status', 'final_decision', 'employer_feedback']);
        });

        Schema::table('peso_jobs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employer_id');
            $table->dropConstrainedForeignId('source_job_id');
            $table->dropColumn([
                'position',
                'qualifications',
                'salary',
                'job_type',
                'vacancies',
                'application_start_date',
                'application_end_date',
                'archived_at',
                'is_filled',
                'filled_at',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_employer_verified');
        });
    }
};
