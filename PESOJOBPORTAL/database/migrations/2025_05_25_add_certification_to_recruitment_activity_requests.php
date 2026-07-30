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
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->string('certification_path')->nullable()->after('job_vacancies_text');
            $table->timestamp('certification_generated_at')->nullable()->after('certification_path');
            $table->unsignedBigInteger('certification_generated_by')->nullable()->after('certification_generated_at');
            $table->foreign('certification_generated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_activity_requests', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['certification_generated_by']);
            $table->dropColumn(['certification_path', 'certification_generated_at', 'certification_generated_by']);
        });
    }
};
