<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofw_requests', function (Blueprint $table) {
            $table->string('ecares_ticket_no')->nullable()->after('user_id');
            $table->date('request_date')->nullable()->after('ecares_ticket_no');
            $table->json('nature_of_case')->nullable()->after('request_date');
            $table->string('nature_of_case_other')->nullable()->after('nature_of_case');
            $table->string('ofw_middle_name')->nullable()->after('ofw_first_name');
            $table->string('ofw_last_name')->nullable()->after('ofw_middle_name');
            $table->string('contact_no')->nullable()->after('ofw_last_name');
            $table->string('position')->nullable()->after('contact_no');
            $table->string('sex')->nullable()->after('position');
            $table->date('birthdate')->nullable()->after('sex');
            $table->string('age', 10)->nullable()->after('birthdate');
            $table->string('civil_status')->nullable()->after('age');
            $table->string('facebook_name')->nullable()->after('civil_status');
            $table->string('highest_education')->nullable()->after('facebook_name');
            $table->string('religion')->nullable()->after('highest_education');
            $table->string('no_children', 10)->nullable()->after('religion');
            $table->string('employer_name')->nullable()->after('no_children');
            $table->string('jobsite')->nullable()->after('employer_name');
            $table->string('tel_no')->nullable()->after('jobsite');
            $table->string('monthly_salary')->nullable()->after('tel_no');
            $table->string('foreign_agency_name')->nullable()->after('monthly_salary');
            $table->string('foreign_agency_address')->nullable()->after('foreign_agency_name');
            $table->string('local_agency_name')->nullable()->after('foreign_agency_address');
            $table->date('latest_departure_date')->nullable()->after('local_agency_name');
            $table->string('previous_employment')->nullable()->after('latest_departure_date');
            $table->string('cause_of_death')->nullable()->after('previous_employment');
            $table->string('place_of_death')->nullable()->after('cause_of_death');
            $table->date('date_of_death')->nullable()->after('place_of_death');
            $table->text('facts_of_case')->nullable()->after('date_of_death');
            $table->string('requesting_party_name')->nullable()->after('facts_of_case');
            $table->string('relationship_to_ofw')->nullable()->after('requesting_party_name');
            $table->string('complete_address')->nullable()->after('relationship_to_ofw');
            $table->string('requesting_party_contact')->nullable()->after('complete_address');
            $table->string('contract_doc_path')->nullable()->after('requesting_party_contact');
        });
    }

    public function down(): void
    {
        Schema::table('ofw_requests', function (Blueprint $table) {
            $table->dropColumn([
                'ecares_ticket_no',
                'request_date',
                'nature_of_case',
                'nature_of_case_other',
                'ofw_middle_name',
                'ofw_last_name',
                'contact_no',
                'position',
                'sex',
                'birthdate',
                'age',
                'civil_status',
                'facebook_name',
                'highest_education',
                'religion',
                'no_children',
                'employer_name',
                'jobsite',
                'tel_no',
                'monthly_salary',
                'foreign_agency_name',
                'foreign_agency_address',
                'local_agency_name',
                'latest_departure_date',
                'previous_employment',
                'cause_of_death',
                'place_of_death',
                'date_of_death',
                'facts_of_case',
                'requesting_party_name',
                'relationship_to_ofw',
                'complete_address',
                'requesting_party_contact',
                'contract_doc_path',
            ]);
        });
    }
};
