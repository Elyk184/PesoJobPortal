<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('company_profiles')) {
            return; // Table already exists, skip
        }

        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Company Basic Information
            $table->string('company_name')->default('')->nullable();
            $table->string('business_name')->default('')->nullable();
            $table->string('trade_name')->default('')->nullable();
            $table->string('acronym_abbreviation')->default('')->nullable();
            $table->year('established_year')->nullable();

            // Company Type & Classification
            $table->enum('office_type', ['main_office', 'branch'])->default('main_office');
            $table->enum('employer_type_detail', ['national_gov', 'local_gov', 'gocc', 'state_college', 'direct_hire', 'local_recruitment', 'overseas_recruitment', 'do174'])->nullable()->default(null);
            $table->enum('workforce_size', ['micro', 'small', 'medium', 'large'])->nullable()->default(null);

            // Business Details
            $table->string('tin')->default('')->nullable(); // Tax Identification Number
            $table->text('line_of_business')->default('')->nullable();

            // Establishment Address
            $table->string('street_village')->default('')->nullable();
            $table->string('barangay')->default('')->nullable();
            $table->string('city_municipality')->default('')->nullable();
            $table->string('province')->default('')->nullable();

            // Establishment Contact Information
            $table->string('establishment_contact_person')->default('')->nullable(); // Owner/President name
            $table->string('establishment_contact_position')->default('')->nullable(); // Position (e.g., President, Owner)
            $table->string('establishment_email')->default('')->nullable();
            $table->string('establishment_phone')->default('')->nullable();

            // Alternative Contact Information
            $table->string('contact_person_name')->default('')->nullable(); // HR Contact
            $table->string('contact_person_phone')->default('')->nullable();

            // Company Documents & Media
            $table->string('logo_path')->default('')->nullable();
            $table->string('business_permit_path')->default('')->nullable();
            $table->string('dti_sec_registration_path')->default('')->nullable();

            // Verification & Status
            $table->enum('verification_status', ['pending', 'under_review', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');

            // Metadata
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
