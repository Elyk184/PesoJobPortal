<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobseeker_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('jobseeker_profiles', 'middle_initial')) {
                $table->string('middle_initial')->nullable()->after('last_name');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'suffix')) {
                $table->string('suffix')->nullable()->after('middle_initial');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'religion')) {
                $table->string('religion')->nullable()->after('date_of_birth');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'civil_status')) {
                $table->string('civil_status')->nullable()->after('religion');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'height')) {
                $table->string('height')->nullable()->after('civil_status');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'tin')) {
                $table->string('tin')->nullable()->after('height');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'email_address')) {
                $table->string('email_address')->nullable()->after('tin');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'training')) {
                $table->json('training')->nullable()->after('education');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'work_experience')) {
                $table->json('work_experience')->nullable()->after('training');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'employment_status')) {
                $table->json('employment_status')->nullable()->after('work_experience');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'job_preference')) {
                $table->json('job_preference')->nullable()->after('employment_status');
            }

            if (! Schema::hasColumn('jobseeker_profiles', 'disability')) {
                $table->json('disability')->nullable()->after('job_preference');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jobseeker_profiles', function (Blueprint $table) {
            $columns = [
                'middle_initial',
                'suffix',
                'religion',
                'civil_status',
                'height',
                'tin',
                'email_address',
                'training',
                'work_experience',
                'employment_status',
                'job_preference',
                'disability',
            ];

            $existingColumns = array_values(array_filter($columns, static fn (string $column): bool => Schema::hasColumn('jobseeker_profiles', $column)));

            if ($existingColumns !== []) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
