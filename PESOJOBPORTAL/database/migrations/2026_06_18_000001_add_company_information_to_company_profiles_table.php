<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_profiles') || Schema::hasColumn('company_profiles', 'company_information')) {
            return;
        }

        Schema::table('company_profiles', function (Blueprint $table) {
            $table->text('company_information')->nullable()->after('business_name');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('company_profiles') || ! Schema::hasColumn('company_profiles', 'company_information')) {
            return;
        }

        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('company_information');
        });
    }
};
