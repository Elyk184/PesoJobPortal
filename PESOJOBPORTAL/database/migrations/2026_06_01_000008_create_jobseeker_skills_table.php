<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('category', ['trade_manual','it_technical','soft_skills','other']);
            $table->string('skill');
            $table->timestamps();
        });

        Schema::create('jobseeker_skills_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('other_enabled')->default(false);
            $table->string('other_text')->nullable();
            $table->boolean('with_certificate')->default(false);
            $table->boolean('by_experience')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_skills_meta');
        Schema::dropIfExists('jobseeker_skills');
    }
};
