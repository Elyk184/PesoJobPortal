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
                if (! Schema::hasColumn('peso_clearances', 'company_name')) {
                    $table->string('company_name')->nullable()->after('remarks');
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
                if (Schema::hasColumn('peso_clearances', 'company_name')) {
                    $table->dropColumn('company_name');
                }
            });
        }
    }
};
