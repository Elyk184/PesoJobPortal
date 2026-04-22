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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->timestamp('admin_approved_at')->nullable()->after('admin_status');
            $table->foreignId('admin_approved_by')->nullable()->constrained('users')->nullOnDelete()->after('admin_approved_at');
            $table->text('admin_notes')->nullable()->after('admin_approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['admin_status', 'admin_approved_at', 'admin_approved_by', 'admin_notes']);
        });
    }
};
