<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Get the current enum values
        $result = DB::selectOne("SHOW COLUMNS FROM `job_applications` LIKE 'status'");

        if (!$result || !isset($result->Type)) {
            return;
        }

        if (!str_starts_with($result->Type, 'enum(')) {
            return;
        }

        // Parse current enum values
        preg_match_all("/'([^']+)'/", $result->Type, $matches);
        $currentValues = $matches[1] ?? [];

        // Define all required status values
        $requiredValues = ['pending', 'reviewing', 'shortlisted', 'interview', 'interviewed', 'hired', 'rejected'];

        // Check if we need to add any new values
        $newValues = array_diff($requiredValues, $currentValues);

        if (empty($newValues) && count($currentValues) === count($requiredValues)) {
            return;
        }

        // Combine existing values with new ones
        $allValues = array_unique(array_merge($currentValues, $requiredValues));

        // Build new enum definition
        $enumString = implode(",", array_map(fn($v) => "'" . $v . "'", $allValues));
        $newType = "enum({$enumString})";

        // Drop the old enum and create new one
        DB::statement("ALTER TABLE `job_applications` MODIFY COLUMN `status` {$newType} DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE `job_applications` MODIFY COLUMN `status` enum('pending','reviewed','interviewed','hired','rejected') DEFAULT 'pending'");
    }
};
