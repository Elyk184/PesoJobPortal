<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofw_requests', function (Blueprint $table) {
            $table->string('ofw_first_name')->nullable()->after('user_id');
            $table->string('passport_no')->nullable()->after('ofw_first_name');
            $table->text('statement')->nullable()->after('passport_no');
            $table->string('contact_doc_path')->nullable()->after('statement');
            $table->string('passport_doc_path')->nullable()->after('contact_doc_path');
        });
    }

    public function down(): void
    {
        Schema::table('ofw_requests', function (Blueprint $table) {
            $table->dropColumn([
                'ofw_first_name',
                'passport_no',
                'statement',
                'contact_doc_path',
                'passport_doc_path',
            ]);
        });
    }
};
