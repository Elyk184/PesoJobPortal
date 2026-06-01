<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('recruitment_activity_requests')) {
            Schema::table('recruitment_activity_requests', function (Blueprint $table) {
                $table->string('letter_of_intent_original_name')->nullable()->after('letter_of_intent_path');
                $table->string('dmw_certificate_original_name')->nullable()->after('dmw_certificate_path');
                $table->string('recruitment_officer_id_original_name')->nullable()->after('recruitment_officer_id_path');
                $table->string('job_order_balance_original_name')->nullable()->after('job_order_balance_path');
                $table->string('deployment_report_original_name')->nullable()->after('deployment_report_path');
                $table->string('affidavit_undertaking_original_name')->nullable()->after('affidavit_undertaking_path');
                $table->string('sra_authority_file_original_name')->nullable()->after('sra_authority_file_path');
                $table->string('business_permit_original_name')->nullable()->after('business_permit_path');
                $table->string('lra_recruitment_officer_id_original_name')->nullable()->after('lra_recruitment_officer_id_path');
                $table->string('job_vacancies_original_name')->nullable()->after('job_vacancies_path');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('recruitment_activity_requests')) {
            Schema::table('recruitment_activity_requests', function (Blueprint $table) {
                $table->dropColumn([
                    'letter_of_intent_original_name',
                    'dmw_certificate_original_name',
                    'recruitment_officer_id_original_name',
                    'job_order_balance_original_name',
                    'deployment_report_original_name',
                    'affidavit_undertaking_original_name',
                    'sra_authority_file_original_name',
                    'business_permit_original_name',
                    'lra_recruitment_officer_id_original_name',
                    'job_vacancies_original_name',
                ]);
            });
        }
    }
};
