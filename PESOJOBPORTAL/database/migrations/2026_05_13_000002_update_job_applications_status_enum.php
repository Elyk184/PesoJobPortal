<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any problematic status values to valid ones
        DB::table('job_applications')
            ->where('status', 'shortlisted')
            ->update(['status' => 'reviewing']);

        DB::table('job_applications')
            ->where('status', 'interview')
            ->update(['status' => 'interviewed']);

        // Update the enum to remove 'shortlisted' and 'interview', add 'recommended'
        DB::statement("ALTER TABLE `job_applications` MODIFY COLUMN `status` enum('pending', 'reviewing', 'recommended', 'interviewed', 'hired', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous enum values
        DB::statement("ALTER TABLE `job_applications` MODIFY COLUMN `status` enum('pending', 'reviewing', 'shortlisted', 'interview', 'interviewed', 'hired', 'rejected') DEFAULT 'pending'");
    }
};
