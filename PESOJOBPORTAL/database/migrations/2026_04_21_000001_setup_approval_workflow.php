<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change peso_jobs default status to 'pending' for approval
        DB::statement("ALTER TABLE `peso_jobs` MODIFY `status` ENUM('active','pending','draft','closed') NOT NULL DEFAULT 'pending'");

        // Add approval tracking columns if they don't exist
        if (!Schema::hasColumn('peso_jobs', 'approved_at')) {
            Schema::table('peso_jobs', function (Blueprint $table) {
                $table->timestamp('approved_at')->nullable()->after('status');
                $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
                $table->text('rejection_reason')->nullable()->after('approved_by');
                
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Ensure recruitment_activity_requests has correct status handling
        if (Schema::hasTable('recruitment_activity_requests')) {
            if (!Schema::hasColumn('recruitment_activity_requests', 'approved_at')) {
                Schema::table('recruitment_activity_requests', function (Blueprint $table) {
                    $table->timestamp('approved_at')->nullable()->after('status');
                    $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
                    
                    $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                });
            }
        }

        // Ensure employer_documents table exists with approval fields
        if (Schema::hasTable('employer_documents')) {
            if (!Schema::hasColumn('employer_documents', 'approved_at')) {
                Schema::table('employer_documents', function (Blueprint $table) {
                    $table->timestamp('approved_at')->nullable()->after('status');
                    $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
                    
                    $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peso_jobs', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['approved_by']);
            $table->dropColumn(['approved_at', 'approved_by', 'rejection_reason']);
        });

        DB::statement("ALTER TABLE `peso_jobs` MODIFY `status` ENUM('active','pending','draft','closed') NOT NULL DEFAULT 'active'");

        if (Schema::hasTable('recruitment_activity_requests')) {
            Schema::table('recruitment_activity_requests', function (Blueprint $table) {
                $table->dropForeignKeyIfExists(['approved_by']);
                $table->dropColumn(['approved_at', 'approved_by']);
            });
        }

        if (Schema::hasTable('employer_documents')) {
            Schema::table('employer_documents', function (Blueprint $table) {
                $table->dropForeignKeyIfExists(['approved_by']);
                $table->dropColumn(['approved_at', 'approved_by']);
            });
        }
    }
};
