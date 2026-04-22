<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            // Company Basic Information
            $table->string('company_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('acronym_abbreviation')->nullable();
            
            // Company Type & Classification
            $table->enum('office_type', ['main_office', 'branch'])->default('main_office');
            $table->enum('employer_type_detail', ['national_gov', 'local_gov', 'gocc', 'state_college', 'direct_hire', 'local_recruitment', 'overseas_recruitment', 'do174'])->nullable();
            $table->enum('workforce_size', ['micro', 'small', 'medium', 'large'])->nullable();
            
            // Business Details
            $table->string('tin')->nullable(); // Tax Identification Number
            $table->text('line_of_business')->nullable();
            
            // Establishment Address
            $table->string('street_village')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('province')->nullable();
            
            // Establishment Contact Information
            $table->string('establishment_contact_person')->nullable(); // Owner/President name
            $table->string('establishment_contact_position')->nullable(); // Position (e.g., President, Owner)
            $table->string('establishment_email')->nullable();
            $table->string('establishment_phone')->nullable();
            
            // Alternative Contact Information
            $table->string('contact_person_name')->nullable(); // HR Contact
            $table->string('contact_person_phone')->nullable();
            
            // Company Documents & Media
            $table->string('logo_path')->nullable();
            $table->string('business_permit_path')->nullable();
            $table->string('dti_sec_registration_path')->nullable();
            
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
