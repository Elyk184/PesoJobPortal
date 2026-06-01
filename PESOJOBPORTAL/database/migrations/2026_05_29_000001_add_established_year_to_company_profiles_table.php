<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_profiles') || Schema::hasColumn('company_profiles', 'established_year')) {
            return;
        }

        Schema::table('company_profiles', function (Blueprint $table) {
            $table->year('established_year')->nullable()->after('acronym_abbreviation');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('company_profiles') || ! Schema::hasColumn('company_profiles', 'established_year')) {
            return;
        }

        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('established_year');
        });
    }
};
