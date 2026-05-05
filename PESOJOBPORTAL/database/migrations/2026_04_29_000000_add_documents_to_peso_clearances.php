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
        if (Schema::hasTable('peso_clearances')) {
            Schema::table('peso_clearances', function (Blueprint $table) {
                if (!Schema::hasColumn('peso_clearances', 'peso_clearance_assurance_receipt_path')) {
                    $table->string('peso_clearance_assurance_receipt_path')->nullable()->after('remarks');
                }
                if (!Schema::hasColumn('peso_clearances', 'barangay_clearance_path')) {
                    $table->string('barangay_clearance_path')->nullable()->after('peso_clearance_assurance_receipt_path');
                }
                if (!Schema::hasColumn('peso_clearances', 'is_first_time_jobseeker')) {
                    $table->boolean('is_first_time_jobseeker')->default(false)->after('barangay_clearance_path');
                }
                if (!Schema::hasColumn('peso_clearances', 'first_time_jobseeker_document_path')) {
                    $table->string('first_time_jobseeker_document_path')->nullable()->after('is_first_time_jobseeker');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('peso_clearances')) {
            Schema::table('peso_clearances', function (Blueprint $table) {
                if (Schema::hasColumn('peso_clearances', 'peso_clearance_assurance_receipt_path')) {
                    $table->dropColumn('peso_clearance_assurance_receipt_path');
                }
                if (Schema::hasColumn('peso_clearances', 'barangay_clearance_path')) {
                    $table->dropColumn('barangay_clearance_path');
                }
                if (Schema::hasColumn('peso_clearances', 'is_first_time_jobseeker')) {
                    $table->dropColumn('is_first_time_jobseeker');
                }
                if (Schema::hasColumn('peso_clearances', 'first_time_jobseeker_document_path')) {
                    $table->dropColumn('first_time_jobseeker_document_path');
                }
            });
        }
    }
};
