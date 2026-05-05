<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            // Add verification status and related fields if they don't exist
            if (!Schema::hasColumn('company_profiles', 'verification_status')) {
                $table->enum('verification_status', ['pending', 'under_review', 'verified', 'rejected'])->default('pending')->after('logo_path');
            }
            
            if (!Schema::hasColumn('company_profiles', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verification_status');
            }
            
            if (!Schema::hasColumn('company_profiles', 'verified_at')) {
                $table->dateTime('verified_at')->nullable()->after('verification_notes');
            }
            
            if (!Schema::hasColumn('company_profiles', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null')->after('verified_at');
            }
            
            if (!Schema::hasColumn('company_profiles', 'deleted_at')) {
                $table->softDeletes()->after('verified_by');
            }

            // Add additional fields to match the newer schema
            if (!Schema::hasColumn('company_profiles', 'business_name')) {
                $table->string('business_name')->nullable()->after('company_name');
            }
            
            if (!Schema::hasColumn('company_profiles', 'trade_name')) {
                $table->string('trade_name')->nullable()->after('business_name');
            }
            
            if (!Schema::hasColumn('company_profiles', 'acronym_abbreviation')) {
                $table->string('acronym_abbreviation')->nullable()->after('trade_name');
            }
            
            if (!Schema::hasColumn('company_profiles', 'office_type')) {
                $table->enum('office_type', ['main_office', 'branch'])->default('main_office')->after('acronym_abbreviation');
            }
            
            if (!Schema::hasColumn('company_profiles', 'employer_type_detail')) {
                $table->enum('employer_type_detail', ['national_gov', 'local_gov', 'gocc', 'state_college', 'direct_hire', 'local_recruitment', 'overseas_recruitment', 'do174'])->nullable()->after('office_type');
            }
            
            if (!Schema::hasColumn('company_profiles', 'workforce_size')) {
                $table->enum('workforce_size', ['micro', 'small', 'medium', 'large'])->nullable()->after('employer_type_detail');
            }
            
            if (!Schema::hasColumn('company_profiles', 'tin')) {
                $table->string('tin')->nullable()->after('workforce_size');
            }
            
            if (!Schema::hasColumn('company_profiles', 'line_of_business')) {
                $table->text('line_of_business')->nullable()->after('tin');
            }
            
            if (!Schema::hasColumn('company_profiles', 'street_village')) {
                $table->string('street_village')->nullable()->after('line_of_business');
            }
            
            if (!Schema::hasColumn('company_profiles', 'barangay')) {
                $table->string('barangay')->nullable()->after('street_village');
            }
            
            if (!Schema::hasColumn('company_profiles', 'city_municipality')) {
                $table->string('city_municipality')->nullable()->after('barangay');
            }
            
            if (!Schema::hasColumn('company_profiles', 'establishment_contact_person')) {
                $table->string('establishment_contact_person')->nullable()->after('city_municipality');
            }
            
            if (!Schema::hasColumn('company_profiles', 'establishment_contact_position')) {
                $table->string('establishment_contact_position')->nullable()->after('establishment_contact_person');
            }
            
            if (!Schema::hasColumn('company_profiles', 'establishment_email')) {
                $table->string('establishment_email')->nullable()->after('establishment_contact_position');
            }
            
            if (!Schema::hasColumn('company_profiles', 'establishment_phone')) {
                $table->string('establishment_phone')->nullable()->after('establishment_email');
            }
            
            if (!Schema::hasColumn('company_profiles', 'contact_person_name')) {
                $table->string('contact_person_name')->nullable()->after('establishment_phone');
            }
            
            if (!Schema::hasColumn('company_profiles', 'contact_person_phone')) {
                $table->string('contact_person_phone')->nullable()->after('contact_person_name');
            }
            
            if (!Schema::hasColumn('company_profiles', 'business_permit_path')) {
                $table->string('business_permit_path')->nullable()->after('contact_person_phone');
            }
            
            if (!Schema::hasColumn('company_profiles', 'dti_sec_registration_path')) {
                $table->string('dti_sec_registration_path')->nullable()->after('business_permit_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            // Drop columns if they exist (in reverse order)
            $columns = [
                'dti_sec_registration_path',
                'business_permit_path',
                'contact_person_phone',
                'contact_person_name',
                'establishment_phone',
                'establishment_email',
                'establishment_contact_position',
                'establishment_contact_person',
                'city_municipality',
                'barangay',
                'street_village',
                'line_of_business',
                'tin',
                'workforce_size',
                'employer_type_detail',
                'office_type',
                'acronym_abbreviation',
                'trade_name',
                'business_name',
                'verified_by',
                'verified_at',
                'verification_notes',
                'verification_status',
                'deleted_at',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('company_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
