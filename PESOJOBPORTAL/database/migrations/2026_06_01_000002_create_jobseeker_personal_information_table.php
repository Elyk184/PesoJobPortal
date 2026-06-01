<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name', 100);
            $table->string('middle_initial', 10)->nullable();
            $table->string('surname', 100);
            $table->string('suffix', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('civil_status', 50)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->string('tin', 20)->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->string('email_address', 255)->nullable();
            $table->boolean('currently_in_school')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_personal_information');
    }
};
