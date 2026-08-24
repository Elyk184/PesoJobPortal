<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ofw_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('civil_status', 30)->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('facebook_name')->nullable();
            $table->text('address_philippines')->nullable();
            $table->text('address_abroad')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('jobsite_country')->nullable();
            $table->string('monthly_salary')->nullable();
            $table->string('local_agency')->nullable();
            $table->string('foreign_agency')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ofw_profiles');
    }
};
