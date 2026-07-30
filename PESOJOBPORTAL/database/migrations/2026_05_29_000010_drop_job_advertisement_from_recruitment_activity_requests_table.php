<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            if (Schema::hasColumn('recruitment_activity_requests', 'job_advertisement_path')) {
                $table->dropColumn('job_advertisement_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->string('job_advertisement_path')->nullable();
        });
    }
};
