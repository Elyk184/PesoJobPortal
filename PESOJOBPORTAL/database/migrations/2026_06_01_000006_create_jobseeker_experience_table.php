<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('from_date', 50)->nullable();
            $table->string('to_date', 50)->nullable();
            $table->decimal('salary_amount', 12, 2)->nullable();
            $table->string('salary_type', 50)->nullable();
            $table->text('details')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_experience');
    }
};
