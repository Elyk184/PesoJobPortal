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
        Schema::table('users', function (Blueprint $table) {
            // Approval tracking fields
            $table->boolean('is_approved')->nullable()->after('role');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnDelete()->after('approved_at');
            
            // Rejection tracking fields
            $table->text('rejection_reason')->nullable()->after('approved_by');
            $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            $table->foreignId('rejected_by')->nullable()->constrained('users')->cascadeOnDelete()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor('users', 'approved_by');
            $table->dropForeignIdFor('users', 'rejected_by');
            $table->dropColumn([
                'is_approved',
                'approved_at',
                'approved_by',
                'rejection_reason',
                'rejected_at',
                'rejected_by',
            ]);
        });
    }
};
