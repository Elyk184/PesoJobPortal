<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('email');
            }
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('user_profiles', 'company_name')) {
                $table->string('company_name')->nullable()->after('photo_path');
            }
            if (! Schema::hasColumn('user_profiles', 'business_name')) {
                $table->string('business_name')->nullable()->after('company_name');
            }
            if (! Schema::hasColumn('user_profiles', 'trade_name')) {
                $table->string('trade_name')->nullable()->after('business_name');
            }
            if (! Schema::hasColumn('user_profiles', 'acronym_abbreviation')) {
                $table->string('acronym_abbreviation')->nullable()->after('trade_name');
            }
            if (! Schema::hasColumn('user_profiles', 'office_type')) {
                $table->string('office_type')->nullable()->after('acronym_abbreviation');
            }
            if (! Schema::hasColumn('user_profiles', 'tin')) {
                $table->string('tin')->nullable()->after('office_type');
            }
            if (! Schema::hasColumn('user_profiles', 'employer_type_detail')) {
                $table->string('employer_type_detail')->nullable()->after('tin');
            }
            if (! Schema::hasColumn('user_profiles', 'workforce_size')) {
                $table->string('workforce_size')->nullable()->after('employer_type_detail');
            }
            if (! Schema::hasColumn('user_profiles', 'line_of_business')) {
                $table->string('line_of_business')->nullable()->after('workforce_size');
            }
            if (! Schema::hasColumn('user_profiles', 'street_village')) {
                $table->string('street_village')->nullable()->after('line_of_business');
            }
            if (! Schema::hasColumn('user_profiles', 'barangay')) {
                $table->string('barangay')->nullable()->after('street_village');
            }
            if (! Schema::hasColumn('user_profiles', 'city_municipality')) {
                $table->string('city_municipality')->nullable()->after('barangay');
            }
            if (! Schema::hasColumn('user_profiles', 'province')) {
                $table->string('province')->nullable()->after('city_municipality');
            }
            if (! Schema::hasColumn('user_profiles', 'establishment_contact_person')) {
                $table->string('establishment_contact_person')->nullable()->after('province');
            }
            if (! Schema::hasColumn('user_profiles', 'contact_person_name')) {
                $table->string('contact_person_name')->nullable()->after('establishment_contact_person');
            }
            if (! Schema::hasColumn('user_profiles', 'establishment_contact_position')) {
                $table->string('establishment_contact_position')->nullable()->after('contact_person_name');
            }
            if (! Schema::hasColumn('user_profiles', 'establishment_phone')) {
                $table->string('establishment_phone')->nullable()->after('establishment_contact_position');
            }
            if (! Schema::hasColumn('user_profiles', 'contact_person_phone')) {
                $table->string('contact_person_phone')->nullable()->after('establishment_phone');
            }
            if (! Schema::hasColumn('user_profiles', 'establishment_email')) {
                $table->string('establishment_email')->nullable()->after('contact_person_phone');
            }
            if (! Schema::hasColumn('user_profiles', 'logo_path')) {
                $table->string('logo_path')->nullable()->after('establishment_email');
            }
            if (! Schema::hasColumn('user_profiles', 'business_permit_path')) {
                $table->string('business_permit_path')->nullable()->after('logo_path');
            }
            if (! Schema::hasColumn('user_profiles', 'dti_sec_registration_path')) {
                $table->string('dti_sec_registration_path')->nullable()->after('business_permit_path');
            }
            if (! Schema::hasColumn('user_profiles', 'verification_status')) {
                $table->string('verification_status')->default('pending')->after('dti_sec_registration_path');
            }
            if (! Schema::hasColumn('user_profiles', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verification_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique('users_username_unique');
                $table->dropColumn('username');
            }
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $columns = [
                'company_name',
                'business_name',
                'trade_name',
                'acronym_abbreviation',
                'office_type',
                'tin',
                'employer_type_detail',
                'workforce_size',
                'line_of_business',
                'street_village',
                'barangay',
                'city_municipality',
                'province',
                'establishment_contact_person',
                'contact_person_name',
                'establishment_contact_position',
                'establishment_phone',
                'contact_person_phone',
                'establishment_email',
                'logo_path',
                'business_permit_path',
                'dti_sec_registration_path',
                'verification_status',
                'verification_notes',
            ];

            $existing = array_values(array_filter($columns, static fn (string $column): bool => Schema::hasColumn('user_profiles', $column)));

            if (! empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};
