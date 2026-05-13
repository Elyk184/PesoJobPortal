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
        // Add 'admin_to_employer' to the recommendation_type enum
        \DB::statement("ALTER TABLE recommended_applicants MODIFY COLUMN recommendation_type ENUM('employer_to_employer', 'employer_to_peso', 'peso_to_employer', 'admin_to_employer', 'general') DEFAULT 'general'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        \DB::statement("ALTER TABLE recommended_applicants MODIFY COLUMN recommendation_type ENUM('employer_to_employer', 'employer_to_peso', 'peso_to_employer', 'general') DEFAULT 'general'");
    }
};
