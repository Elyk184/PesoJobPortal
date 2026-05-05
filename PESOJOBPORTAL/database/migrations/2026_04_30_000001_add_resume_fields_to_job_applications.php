<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('resume_path')->nullable()->after('notes');
            $table->enum('resume_type', ['upload', 'profile', 'builder'])->default('upload')->after('resume_path');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['resume_path', 'resume_type']);
        });
    }
};
