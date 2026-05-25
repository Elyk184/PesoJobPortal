<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'jobseeker', 'ofw') NOT NULL DEFAULT 'jobseeker'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'jobseeker') NOT NULL DEFAULT 'jobseeker'");
    }
};