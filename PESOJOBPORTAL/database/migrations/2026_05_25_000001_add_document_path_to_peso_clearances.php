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
        Schema::table('peso_clearances', function (Blueprint $table) {
            // Add document_path column if it doesn't exist
            if (!Schema::hasColumn('peso_clearances', 'document_path')) {
                $table->string('document_path')->nullable()->after('first_time_jobseeker_document_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peso_clearances', function (Blueprint $table) {
            if (Schema::hasColumn('peso_clearances', 'document_path')) {
                $table->dropColumn('document_path');
            }
        });
    }
};
