<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofw_form_submissions', function (Blueprint $table) {
            if (! Schema::hasColumn('ofw_form_submissions', 'status')) {
                $table->string('status', 30)->default('submitted')->after('form_type')->index();
            }

            if (! Schema::hasColumn('ofw_form_submissions', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('pdf_filename');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ofw_form_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('ofw_form_submissions', 'accepted_at')) {
                $table->dropColumn('accepted_at');
            }

            if (Schema::hasColumn('ofw_form_submissions', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }
        });
    }
};
