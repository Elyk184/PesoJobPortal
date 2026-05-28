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
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('recruitment_activity_requests', 'confirm_clicked_at')) {
                $table->timestamp('confirm_clicked_at')->nullable()->after('submitted_by_employer_at');
            }

            if (! Schema::hasColumn('recruitment_activity_requests', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('confirm_clicked_at');
            }

            if (! Schema::hasColumn('recruitment_activity_requests', 'submitted_via')) {
                $table->string('submitted_via', 50)->nullable()->after('submitted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->dropColumn([
                'confirm_clicked_at',
                'submitted_at',
                'submitted_via',
            ]);
        });
    }
};
