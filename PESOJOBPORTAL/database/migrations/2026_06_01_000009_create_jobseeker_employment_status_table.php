<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_employment_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('has_work_experience')->nullable();
            $table->boolean('wage_employed')->default(false);
            $table->string('wage_employed_specify')->nullable();
            $table->boolean('self_employed')->default(false);
            $table->string('self_employed_specify')->nullable();
            $table->boolean('unemployed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_employment_status');
    }
};
