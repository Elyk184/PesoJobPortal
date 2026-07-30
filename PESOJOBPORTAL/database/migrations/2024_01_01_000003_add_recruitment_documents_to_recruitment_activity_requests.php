<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            // SRA specific fields
            $table->string('dmw_certificate_path')->nullable()->after('letter_of_intent_path');
            $table->string('recruitment_officer_id_path')->nullable()->after('dmw_certificate_path');
            $table->string('job_order_balance_path')->nullable()->after('recruitment_officer_id_path');
            $table->string('deployment_report_path')->nullable()->after('job_order_balance_path');
            $table->string('affidavit_undertaking_path')->nullable()->after('deployment_report_path');
            $table->string('sra_authority_file_path')->nullable()->after('affidavit_undertaking_path');

            // LRA specific fields
            $table->string('business_permit_path')->nullable()->after('sra_authority_file_path');
            $table->string('lra_recruitment_officer_id_path')->nullable()->after('business_permit_path');
            $table->string('job_vacancies_path')->nullable()->after('lra_recruitment_officer_id_path');
            $table->longText('job_vacancies_text')->nullable()->after('job_vacancies_path');
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->dropColumn([
                'dmw_certificate_path',
                'recruitment_officer_id_path',
                'job_order_balance_path',
                'deployment_report_path',
                'affidavit_undertaking_path',
                'sra_authority_file_path',
                'business_permit_path',
                'lra_recruitment_officer_id_path',
                'job_vacancies_path',
                'job_vacancies_text',
            ]);
        });
    }
};
