<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->json('personal_information')->nullable()->after('user_id');
            $table->json('present_address')->nullable()->after('personal_information');
            $table->json('permanent_address')->nullable()->after('present_address');
            $table->json('training')->nullable()->after('education');
            $table->json('eligibility')->nullable()->after('experience');
            $table->json('other_skills')->nullable()->after('eligibility');
            $table->json('employment_status')->nullable()->after('other_skills');
            $table->json('job_preferences')->nullable()->after('employment_status');
            $table->json('languages')->nullable()->after('job_preferences');
            $table->json('disability')->nullable()->after('languages');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'personal_information',
                'present_address',
                'permanent_address',
                'training',
                'eligibility',
                'other_skills',
                'employment_status',
                'job_preferences',
                'languages',
                'disability',
            ]);
        });
    }
};
