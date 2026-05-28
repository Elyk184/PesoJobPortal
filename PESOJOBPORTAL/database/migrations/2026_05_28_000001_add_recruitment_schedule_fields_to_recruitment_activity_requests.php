<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            // Submitted by employer from the "Confirm & Submit" modal
            // (submit-documents.blade.php)
            if (! Schema::hasColumn('recruitment_activity_requests', 'recruitment_start_date')) {
                $table->date('recruitment_start_date')->nullable()->after('company_profile_path');
            }

            if (! Schema::hasColumn('recruitment_activity_requests', 'recruitment_end_date')) {
                $table->date('recruitment_end_date')->nullable()->after('recruitment_start_date');
            }

            if (! Schema::hasColumn('recruitment_activity_requests', 'recruitment_days')) {
                $table->unsignedInteger('recruitment_days')->nullable()->after('recruitment_end_date');
            }

            if (! Schema::hasColumn('recruitment_activity_requests', 'submitted_by_employer_at')) {
                $table->timestamp('submitted_by_employer_at')->nullable()->after('recruitment_days');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->dropColumn([
                'recruitment_start_date',
                'recruitment_end_date',
                'recruitment_days',
                'submitted_by_employer_at',
            ]);
        });
    }
};

