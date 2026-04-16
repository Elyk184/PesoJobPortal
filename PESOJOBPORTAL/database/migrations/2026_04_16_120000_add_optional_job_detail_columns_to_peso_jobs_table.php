<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peso_jobs', function (Blueprint $table) {
            if (! Schema::hasColumn('peso_jobs', 'key_responsibilities')) {
                $table->text('key_responsibilities')->nullable()->after('qualifications');
            }

            if (! Schema::hasColumn('peso_jobs', 'preferred_skills')) {
                $table->text('preferred_skills')->nullable()->after('key_responsibilities');
            }

            if (! Schema::hasColumn('peso_jobs', 'experience')) {
                $table->text('experience')->nullable()->after('preferred_skills');
            }

            if (! Schema::hasColumn('peso_jobs', 'education')) {
                $table->text('education')->nullable()->after('experience');
            }

            if (! Schema::hasColumn('peso_jobs', 'benefits')) {
                $table->text('benefits')->nullable()->after('education');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peso_jobs', function (Blueprint $table) {
            $dropColumns = [];

            foreach (['key_responsibilities', 'preferred_skills', 'experience', 'education', 'benefits'] as $column) {
                if (Schema::hasColumn('peso_jobs', $column)) {
                    $dropColumns[] = $column;
                }
            }

            if (! empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
