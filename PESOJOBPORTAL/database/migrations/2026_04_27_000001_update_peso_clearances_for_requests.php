<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('peso_clearances')) {
            return;
        }

        if (! Schema::hasColumn('peso_clearances', 'request_date')) {
            Schema::table('peso_clearances', function (Blueprint $table) {
                $table->dateTime('request_date')->nullable()->after('user_id');
            });
        }

        DB::statement('ALTER TABLE `peso_clearances` MODIFY `issue_date` DATETIME NULL');
    }

    public function down(): void
    {
        if (! Schema::hasTable('peso_clearances')) {
            return;
        }

        DB::statement('ALTER TABLE `peso_clearances` MODIFY `issue_date` DATETIME NOT NULL');

        if (Schema::hasColumn('peso_clearances', 'request_date')) {
            Schema::table('peso_clearances', function (Blueprint $table) {
                $table->dropColumn('request_date');
            });
        }
    }
};
