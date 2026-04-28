<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('user_profiles', 'personal_information')) {
                $table->json('personal_information')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('user_profiles', 'present_address')) {
                $table->json('present_address')->nullable()->after('personal_information');
            }

            if (! Schema::hasColumn('user_profiles', 'permanent_address')) {
                $table->json('permanent_address')->nullable()->after('present_address');
            }

            if (! Schema::hasColumn('user_profiles', 'resume_name')) {
                $table->string('resume_name')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('user_profiles', 'resume_email')) {
                $table->string('resume_email')->nullable()->after('resume_name');
            }

            if (! Schema::hasColumn('user_profiles', 'training')) {
                $table->json('training')->nullable()->after('experience');
            }

            if (! Schema::hasColumn('user_profiles', 'eligibility')) {
                $table->json('eligibility')->nullable()->after('training');
            }

            if (! Schema::hasColumn('user_profiles', 'other_skills')) {
                $table->json('other_skills')->nullable()->after('eligibility');
            }

            if (! Schema::hasColumn('user_profiles', 'employment_status')) {
                $table->json('employment_status')->nullable()->after('other_skills');
            }

            if (! Schema::hasColumn('user_profiles', 'job_preferences')) {
                $table->json('job_preferences')->nullable()->after('employment_status');
            }

            if (! Schema::hasColumn('user_profiles', 'languages')) {
                $table->json('languages')->nullable()->after('job_preferences');
            }

            if (! Schema::hasColumn('user_profiles', 'disability')) {
                $table->json('disability')->nullable()->after('languages');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $columns = [
                'personal_information',
                'present_address',
                'permanent_address',
                'resume_name',
                'resume_email',
                'training',
                'eligibility',
                'other_skills',
                'employment_status',
                'job_preferences',
                'languages',
                'disability',
            ];

            $existing = array_values(array_filter($columns, static fn (string $column): bool => Schema::hasColumn('user_profiles', $column)));

            if (! empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};
