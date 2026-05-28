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
        Schema::table('peso_clearances', function (Blueprint $table) {
            if (! Schema::hasColumn('peso_clearances', 'residence_address')) {
                $table->string('residence_address')->nullable()->after('remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peso_clearances', function (Blueprint $table) {
            if (Schema::hasColumn('peso_clearances', 'residence_address')) {
                $table->dropColumn('residence_address');
            }
        });
    }
};
