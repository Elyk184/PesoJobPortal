<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE employer_notifications MODIFY `type` ENUM('job_fair_invite','referral_update','general','job_update','verification_update') NOT NULL DEFAULT 'general'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE employer_notifications MODIFY `type` ENUM('job_fair_invite','referral_update','general') NOT NULL DEFAULT 'general'");
    }
};
