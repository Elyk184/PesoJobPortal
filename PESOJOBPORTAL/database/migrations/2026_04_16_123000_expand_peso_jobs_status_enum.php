<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `peso_jobs` MODIFY `status` ENUM('active','pending','draft','closed') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `peso_jobs` MODIFY `status` ENUM('active','closed') NOT NULL DEFAULT 'active'");
    }
};
