<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only run if table exists
        if (!Schema::hasTable('company_profiles')) {
            return;
        }

        // Use raw SQL to add defaults to all string columns that are nullable
        // This fixes MySQL strict mode compatibility
        try {
            DB::statement("ALTER TABLE company_profiles MODIFY company_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY business_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY trade_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY acronym_abbreviation VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY tin VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY line_of_business LONGTEXT DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY street_village VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY barangay VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY city_municipality VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY province VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY establishment_contact_person VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY establishment_contact_position VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY establishment_email VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY establishment_phone VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY contact_person_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY contact_person_phone VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY logo_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY business_permit_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE company_profiles MODIFY dti_sec_registration_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci");
        } catch (\Exception $e) {
            // Silently fail - columns might already have defaults
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};
